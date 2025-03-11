<?php

namespace FinalProject\Model;

require_once(__DIR__ . '/../utils/useResponse.php');
require_once(__DIR__ . '/../utils/useImages.php');
require_once(__DIR__ . '/../utils/useRandomize.php');

use FinalProject\Utils;

use DateTime;
use PDO;
use PDOException;
use Exception;

class Event
{
    private $connection;
    // private $requiredFields = ['title', 'description', 'type', 'start', 'end', 'location', 'cover', 'more_pic[]'];
    private $requiredFields = ['title', 'description', 'type', 'start', 'end', 'location'];

    public function __construct($connection)
    {
        $this->connection = $connection;
    }


    public function createEvent($data = [])
    {
        try {
            $this->connection->beginTransaction();

            $uploadDir = '/var/www/html/public/images/uploads/';
            $coverImage = null;
            $morePics = [];

            foreach ($this->requiredFields as $field) {
                if (empty($data[$field])) {
                    return [
                        "status" => 400,
                        "message" => "Missing required field: $field"
                    ];
                }
            }

            $isUploadedImage = false;

            if (isset($_FILES['cover']) && $_FILES['cover']['error'] === UPLOAD_ERR_OK) {
                $coverImage = uploadFile($_FILES['cover'], $uploadDir);
                unset($_FILES['cover']);

                $isUploadedImage = true;
            }

            if (isset($_FILES['more_pic'])) {
                $morePics = uploadMultipleFiles($_FILES['more_pic'], $uploadDir);

                $isUploadedImage = true;
            }

            if ($isUploadedImage === false) {
                return [
                    "status" => 500,
                    "message" => "เกิดข้อผิดพลาระหว่างอัพโหลดรูปภาพกิจกรรม"
                ];
            }

            $more_pic = json_encode($morePics);

            $now = new DateTime();
            $lastCols = $this->connection->prepare("SELECT id FROM Event ORDER BY id DESC LIMIT 1");
            $lastCols->execute();
            $getCols = $lastCols->fetchColumn();

            $newValue = ($getCols !== false) ? intval($getCols) + 1 : 1;
            $formattedValue = str_pad($newValue, 7, "0", STR_PAD_LEFT);
            $eventId = "AG-" . $now->format('Y') . $formattedValue . uniqid("_event-" . getRandomId(8));

            $userId = $_SESSION['user']['userId'];

            $venue = isset($data['venue']) && $data['venue'] !== '' ? $data['venue'] : '0';
            $maximum = isset($data['maximum']) && is_numeric($data['maximum']) ? intval($data['maximum']) : -1;

            $statement = $this->connection->prepare("
                INSERT INTO Event 
                (`eventId`, `organizeId`, `cover`, `morePics`, `title`, `description`, `venue`, `maximum`, `type`, `link`, `start`, `end`, `location`)
                VALUES 
                (:eventId, :organizeId, :cover, :morePics, :title, :description, :venue, :maximum, :type, :link, :start, :end, :location)
            ");

            $statement->bindParam(':eventId', $eventId);
            $statement->bindParam(':organizeId', $userId);
            $statement->bindParam(':cover', $coverImage);
            $statement->bindParam(':morePics', $more_pic);
            $statement->bindParam(':title', $data['title']);
            $statement->bindParam(':description', $data['description']);
            $statement->bindParam(':venue', $venue);
            $statement->bindParam(':maximum', $maximum);
            $statement->bindParam(':type', $data['type']);
            $statement->bindParam(':link', $data['link']);
            $statement->bindParam(':start', $data['start']);
            $statement->bindParam(':end', $data['end']);
            $statement->bindParam(':location', $data['location']);

            if (!$statement->execute()) {
                $this->connection->rollBack();
                return [
                    "status" => 500,
                    "message" => "เกิดข้อผิดพลาดระหว่างสร้างกิจกรรม"
                ];
            }

            $authorStmt = $this->connection->prepare("
            INSERT INTO `Author` (`authorId`, `eventId`, `role`) 
            VALUES (:authorId, :eventId, :role);
            ");

            $role = "admin";
            $authorStmt->bindParam(':authorId', $userId);
            $authorStmt->bindParam(':eventId', $eventId);
            $authorStmt->bindParam(':role', $role);

            if (!$authorStmt->execute()) {
                $this->connection->rollBack();
                return [
                    "status" => 500,
                    "message" => "ไม่พบผู้ใช้, ลองเข้าสู่ระบบอีกครั้ง"
                ];
            }

            $this->connection->commit();

            return [
                "status" => 201,
                "message" => "Event (" . $eventId . ") created successfully.",
            ];
        } catch (PDOException $e) {
            // Database error: SQLSTATE[HY093]: Invalid parameter number: number of bound variables does not match number of tokens
            $this->connection->rollBack();
            return [
                "status" => 500,
                "message" => "Database error: " . $e->getMessage()
            ];
        } catch (Exception $e) {
            return [
                "status" => 500,
                "message" => "Error: " . $e->getMessage()
            ];
        }
    }

    public function getAllEvents()
    {
        $statement = $this->connection->prepare(
            "
            SELECT
                e.eventId,
                e.cover,
                e.title,
                e.maximum,
                e.type,
                e.start,
                e.end,
                e.venue,
                e.organizeId,
                u.name AS organizeName,
                COUNT(CASE WHEN a.status = 'accepted' THEN a.regId END) AS joined
            FROM Event e
            LEFT JOIN Registration r ON e.eventId = r.eventId
            LEFT JOIN Attendance a ON r.regId = a.regId
            JOIN User u ON e.organizeId = u.userId
            GROUP BY 
                e.eventId, 
                e.cover, 
                e.title, 
                e.maximum, 
                e.type, 
                e.start, 
                e.end,
                e.venue,
                e.organizeId, 
                u.name;
            "
        );

        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public function getAllEventsById($userId)
    {
        $statement = $this->connection->prepare("CALL GetAllEventsByUserId(:userId)");
        $statement->bindParam(':userId', $userId);

        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public function getEventById($id)
    {

        $sql = $this->connection->prepare(
            "SELECT * FROM Event WHERE eventid = :eventid"
        );

        $sql->execute([
            ':eventid' => $id
        ]);

        $result = $sql->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function updateEventById($data = [])
    {
        try {
            $this->connection->beginTransaction();

            $uploadDir = '/var/www/html/public/images/uploads/';
            $coverImage = null;
            $morePics = [];

            foreach ($this->requiredFields as $field) {
                if (empty($data[$field])) {
                    return [
                        "status" => 400,
                        "message" => "กรุณาเช็คข้อมูลให้ถูกต้องก่อนส่งข้อมูล"
                    ];
                }
            }

            $isUploadedImage = !false;

            // removeFile(fileName: $_FILES['cover_exist']['name'], saveDir: $uploadDir);

            if (isset($_FILES['cover']) && $_FILES['cover']['error'] === UPLOAD_ERR_OK) {
                if (isset($_FILES['cover_exist']) && $_FILES['cover']['name'] !== $_FILES['cover_exist']['name']) {
                    if (isset($_FILES['cover_exist']['name']) && $_FILES['cover_exist']['name'] !== '') {
                        $fullPath = $uploadDir . $_FILES['cover_exist']['name'];

                        if (file_exists($fullPath)) {
                            removeFile(fileName: $_FILES['cover_exist']['name'], saveDir: $uploadDir);
                        }
                    }

                    $coverImage = uploadFile($_FILES['cover'], $uploadDir);

                    unset($_FILES['cover']);
                    unset($_FILES['cover_exist']);
                } else {
                    // $coverImage = uploadFile($_FILES['cover'], $uploadDir);
                    $coverImage = $_FILES['cover']['name'];
                }

                $isUploadedImage = true;
            } else {
                return [
                    "status" => 404,
                    "message" => "ไม่พบรูปภาพแบนเนอร์"
                ];
            }

            // if (isset($_FILES['more_pic'])) {
            //     if (isset($_FILES['more_pic_exist'])) {
            //         foreach ($_FILES['more_pic_exist']['name'] as $existingImage) {
            //             removeFile(fileName: $existingImage, saveDir: $uploadDir);
            //         }
            //     }

            //     foreach ($_FILES['more_pic']['name'] as $index => $filename) {
            //         $tempFile = [
            //             'name' => $_FILES['more_pic']['name'][$index],
            //             'type' => $_FILES['more_pic']['type'][$index], 
            //             'tmp_name' => $_FILES['more_pic']['tmp_name'][$index],
            //             'error' => $_FILES['more_pic']['error'][$index],
            //             'size' => $_FILES['more_pic']['size'][$index]
            //         ];

            //         $uploadedFile = uploadFile($tempFile, $uploadDir);

            //         if ($uploadedFile) {
            //             $morePics[] = $uploadedFile;
            //         }
            //     }

            //     $isUploadedImage = true;
            // }

            if (isset($_FILES['more_pic'])) {
                if (isset($_FILES['more_pic_exist'])) {
                    foreach ($_FILES['more_pic_exist']['name'] as $existingFile) {
                        if (!empty($existingFile)) {
                            removeFile(fileName: $existingFile, saveDir: $uploadDir);
                        }
                    }
                }

                $morePics = uploadMultipleFiles($_FILES['more_pic'], $uploadDir);
                $isUploadedImage = true;
            }

            if ($isUploadedImage === false) {
                return [
                    "status" => 500,
                    "message" => "เกิดข้อผิดพลาดระหว่างอัพโหลดรูปภาพกิจกรรม"
                ];
            }

            $more_pic = json_encode($morePics);

            $now = (new DateTime())->format('Y-m-d H:i:s');

            $eventId = $data['eventId'];

            $userId = $_SESSION['user']['userId'];

            $venue = isset($data['venue']) && $data['venue'] !== '' ? $data['venue'] : '0';
            $maximum = isset($data['maximum']) && is_numeric($data['maximum']) ? intval($data['maximum']) : -1;

            $statement = $this->connection->prepare("
                UPDATE Event 
                SET organizeId = :organizeId,
                    cover = :cover,
                    morePics = :morePics,
                    title = :title,
                    description = :description,
                    venue = :venue,
                    maximum = :maximum,
                    type = :type,
                    link = :link,
                    start = :start,
                    end = :end,
                    updated = :updated,
                    location = :location
                WHERE eventId = :eventId
            ");

            // print_r($coverImage);

            $statement->bindParam(':eventId', $eventId);
            $statement->bindParam(':organizeId', $userId);
            $statement->bindParam(':cover', $coverImage);
            $statement->bindParam(':morePics', $more_pic);
            $statement->bindParam(':title', $data['title']);
            $statement->bindParam(':description', $data['description']);
            $statement->bindParam(':venue', $venue);
            $statement->bindParam(':maximum', $maximum);
            $statement->bindParam(':type', $data['type']);
            $statement->bindParam(':link', $data['link']);
            $statement->bindParam(':start', $data['start']);
            $statement->bindParam(':end', $data['end']);
            $statement->bindParam(':updated', $now);
            $statement->bindParam(':location', $data['location']);

            if (!$statement->execute()) {
                $this->connection->rollBack();
                return [
                    "status" => 500,
                    "message" => "เกิดข้อผิดพลาดระหว่างสร้างกิจกรรม"
                ];
            }

            $this->connection->commit();

            return [
                "status" => 201,
                "message" => "Update event complete!",
            ];
        } catch (PDOException $e) {
            $this->connection->rollBack();
            return [
                "status" => 500,
                "message" => "Database error: " . $e->getMessage()
            ];
        } catch (Exception $e) {
            return [
                "status" => 500,
                "message" => "Error: " . $e->getMessage()
            ];
        }
    }

    public function searchEvent($title, $dateStart, $dateEnd)
    {
        try {
            $query = "SELECT * FROM Event WHERE 1";
            $params = [];

            if (!empty($title)) {
                $query .= " AND title LIKE :title";
                $params[':title'] = "%$title%";
            }

            if (!empty($dateStart) && !empty($dateEnd)) {
                $query .= " AND (DATE(start) BETWEEN :dateStart AND :dateEnd OR DATE(end) BETWEEN :dateStart AND :dateEnd)";
                $params[':dateStart'] = $dateStart;
                $params[':dateEnd'] = $dateEnd;
            }

            $stmt = $this->connection->prepare($query);
            $stmt->execute($params);

            $events = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return ["data" => $events];
        } catch (PDOException $e) {
            return ['error' => $e->getMessage(), 'data' => []];
        }
    }

    public function searchEventByCategories($dateType, $eventType)
    {
        try {
            $_SESSION['selected_type'] = $eventType;

            $query = "
            SELECT
                e.eventId,
                e.cover,
                e.title,
                e.maximum,
                e.type,
                e.start,
                e.end,
                e.venue,
                e.organizeId,
                u.name AS organizeName,
                COUNT(CASE WHEN a.status = 'accepted' THEN a.regId END) AS joined
            FROM Event e
            LEFT JOIN Registration r ON e.eventId = r.eventId
            LEFT JOIN Attendance a ON r.regId = a.regId
            JOIN User u ON e.organizeId = u.userId
            WHERE 1=1";
            $params = [];

            $now = new DateTime();

            if (!empty($dateType)) {
                switch ($dateType) {
                    case 'day':
                        $query .= " AND (DATE(e.start) = DATE(:today) OR DATE(e.end) = DATE(:today))";
                        $params[':today'] = $now->format('Y-m-d');
                        break;
                    case 'week':
                        $query .= " AND (DATE(e.start) BETWEEN :weekStart AND :weekEnd OR DATE(e.end) BETWEEN :weekStart AND :weekEnd)";
                        $params[':weekStart'] = $now->format('Y-m-d');
                        $params[':weekEnd'] = $now->modify('+7 days')->format('Y-m-d');
                        break;
                    case 'month':
                        $query .= " AND (
                            (MONTH(e.start) = MONTH(:currentMonth) AND YEAR(e.start) = YEAR(:currentYear)) OR 
                            (MONTH(e.end) = MONTH(:currentMonth) AND YEAR(e.end) = YEAR(:currentYear))
                        )";
                        $params[':currentMonth'] = $now->format('Y-m-d');
                        $params[':currentYear'] = $now->format('Y-m-d');
                        break;
                }
            }

            if (!empty($eventType) && $eventType !== 'any') {
                $query .= " AND e.type = :type OR e.type = 'any'";
                $params[':type'] = $eventType;
            }

            $query .= " GROUP BY 
                e.eventId, 
                e.cover, 
                e.title, 
                e.maximum, 
                e.type, 
                e.start, 
                e.end,
                e.venue,
                e.organizeId, 
                u.name";

            // var_dump($query);

            $stmt = $this->connection->prepare($query);
            $stmt->execute($params);

            $events = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return ["data" => $events];
        } catch (PDOException $e) {
            return ['error' => $e->getMessage(), 'data' => []];
        }
    }

    public function getRegistrationEventByUserId() {}

    public function deleteEventById($userId, $eventId) {
        try {
            $this->connection->beginTransaction();

            $checkAuth = $this->connection->prepare("
                SELECT organizeId FROM Event 
                WHERE eventId = :eventId AND organizeId = :userId
            ");

            $checkAuth->execute([
                ':eventId' => $eventId,
                ':userId' => $userId
            ]);

            if (!$checkAuth->fetch()) {
                return [
                    "status" => 403,
                    "message" => "คุณไม่มีสิทธิ์ลบกิจกรรมนี้"
                ];
            }

            $deleteEvent = $this->connection->prepare("
                DELETE FROM Event 
                WHERE eventId = :eventId
            ");

            $deleteEvent->bindParam(':eventId', $eventId);
            $deleteEvent->execute();

            $this->connection->commit();

            return [
                "status" => 200,
                "message" => "กิจกรรมถูกลบแล้ว"
            ];

        } catch (PDOException $e) {
            $this->connection->rollBack();
            return [
                "status" => 500,
                "message" => "Database error: " . $e->getMessage()
            ];
        }
    }

    public function getmailbyid($userId)
    {
        $sql = $this->connection->prepare("CALL GetMail(:userId)");
        $sql->bindParam(':userId', $userId);

        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
}
