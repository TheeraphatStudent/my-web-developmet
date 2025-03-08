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

            $requiredFields = ['title', 'description', 'type', 'start', 'end', 'location'];
            foreach ($requiredFields as $field) {
                if (empty($data[$field])) {
                    return [
                        "status" => 400,
                        "message" => "Missing required field: $field"
                    ];
                }
            }

            if (isset($_FILES['cover']) && $_FILES['cover']['error'] === UPLOAD_ERR_OK) {
                $coverImage = uploadFile($_FILES['cover'], $uploadDir);
                unset($_FILES['cover']);
            }

            if (isset($_FILES['more_pic'])) {
                $morePics = uploadMultipleFiles($_FILES['more_pic'], $uploadDir);
            }

            $more_pic = json_encode($morePics);

            $now = new DateTime();
            $lastCols = $this->connection->prepare("SELECT id FROM Event ORDER BY id DESC LIMIT 1");
            $lastCols->execute();
            $getCols = $lastCols->fetchColumn();

            $newValue = ($getCols !== false) ? intval($getCols) + 1 : 1;
            $formattedValue = str_pad($newValue, 7, "0", STR_PAD_LEFT);
            $eventId = "AG-" . $now->format('Y') . $formattedValue . uniqid("_event-" . getRandomId(8));

            $venue = isset($data['venue']) && $data['venue'] !== '' ? $data['venue'] : '0';
            $maximum = isset($data['maximum']) && is_numeric($data['maximum']) ? intval($data['maximum']) : -1;

            $statement = $this->connection->prepare("
                INSERT INTO Event 
                (`eventId`, `organizeId`, `cover`, `morePics`, `title`, `description`, `venue`, `maximum`, `type`, `link`, `start`, `end`, `location`)
                VALUES 
                (:eventId, :organizeId, :cover, :morePics, :title, :description, :venue, :maximum, :type, :link, :start, :end, :location)
            ");

            $statement->bindParam(':eventId', $eventId);
            $statement->bindParam(':organizeId', $_SESSION['user']['userId']);
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
                    "message" => "Failed to create event."
                ];
            }

            $this->connection->commit();

            return [
                "status" => 201,
                "message" => "Event (" . $eventId . ") created successfully.",
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

    public function getAllEvents()
    {
        $statement = $this->connection->prepare(
            "SELECT * FROM Event WHERE 1"
        );

        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public function getUsersByRegId($regId) {}

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
        // print_r($_SESSION);
        // echo "<br>";
        // print_r($data);

        $sql = $this->connection->prepare(
            "UPDATE Event 
            SET 
                title = :title, 
                description = :description, 
                venue = :venue, 
                maximum = :maximum, 
                type = :type, 
                link = :link, 
                updated = :updated 
            WHERE eventId = :eventId AND organizeId = :organizeId"
        );

        $now = (new DateTime())->format('Y-m-d H:i:s');

        $sql->bindParam(':eventId', $data['eventId']);
        $sql->bindParam(':organizeId', $_SESSION['user']['userId']);
        $sql->bindParam(':title', $data['title']);
        $sql->bindParam(':description', $data['description']);
        $sql->bindParam(':venue', $data['venue']);
        $sql->bindParam(':maximum', $data['maximum']);
        $sql->bindParam(':type', $data['type']);
        $sql->bindParam(':link', $data['link']);
        $sql->bindParam(':updated', $now);

        $sql->execute();

        $rowCount = $sql->rowCount();
        if ($rowCount > 0) {
            return ["It worked, $rowCount rows updated"];
        } else {
            return ["No rows updated, check the eventId or organizeId"];
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

            $query = "SELECT * FROM Event WHERE 1";
            $params = [];

            $now = new DateTime();

            if (!empty($dateType)) {
                switch ($dateType) {
                    case 'day':
                        $query .= " AND (DATE(start) = DATE(:today) OR DATE(end) = DATE(:today))";
                        $params[':today'] = $now->format('Y-m-d');
                        break;
                    case 'week':
                        $query .= " AND (DATE(start) BETWEEN :weekStart AND :weekEnd OR DATE(end) BETWEEN :weekStart AND :weekEnd)";
                        $params[':weekStart'] = $now->format('Y-m-d');
                        $params[':weekEnd'] = $now->modify('+7 days')->format('Y-m-d');
                        break;
                    case 'month':
                        $query .= " AND (
                            (MONTH(start) = MONTH(:currentMonth) AND YEAR(start) = YEAR(:currentYear)) OR 
                            (MONTH(end) = MONTH(:currentMonth) AND YEAR(end) = YEAR(:currentYear))
                        )";
                        $params[':currentMonth'] = $now->format('Y-m-d');
                        $params[':currentYear'] = $now->format('Y-m-d');
                        break;
                }
            }

            if (!empty($eventType) && $eventType !== 'any') {
                $query .= " AND type = :type";
                $params[':type'] = $eventType;
            }

            $stmt = $this->connection->prepare($query);
            $stmt->execute($params);

            $events = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return ["data" => $events];
        } catch (PDOException $e) {
            return ['error' => $e->getMessage(), 'data' => []];
        }
    }

    public function getRegistrationEventByUserId() {}

    public function deleteEventById() {}
}
