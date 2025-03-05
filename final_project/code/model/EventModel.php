<?php

namespace FinalProject\Model;

require_once(__DIR__ . '/../utils/useResponse.php');
require_once(__DIR__ . '/../utils/useImages.php');
require_once(__DIR__ . '/../utils/useRandomize.php');

use FinalProject\Utils;

use DateTime;
use PDO;
use PDOException;

class Event
{
    private $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }


    public function createEvent($data = [])
    {
        // array: start, end, authors, more_pic

        $uploadDir = '/var/www/html/public/images/uploads/';
        $coverImage = null;
        $morePics = [];

        // print_r($_FILES);

        if (isset($_FILES['cover']) && $_FILES['cover']['error'] === UPLOAD_ERR_OK) {
            $coverImage = uploadFile($_FILES['cover'], $uploadDir);
            unset($_FILES['cover']);
        }

        if (isset($_FILES['more_pic'])) {
            $morePics = uploadMultipleFiles($_FILES['more_pic'], $uploadDir);
        }

        // print_r($coverImage);
        // print_r($morePics);

        $started = json_encode($data['start']);
        $ended = json_encode($data['end']);
        $more_pic = json_encode($morePics);

        $latMatch = [];
        $lonMatch = [];

        preg_match('/lat=([^&]*)/', $data['location'], $latMatch);
        preg_match('/lon=([^&]*)/', $data['location'], $lonMatch);

        $location = json_encode([
            'lat' => $latMatch[1] ?? 0,
            'lon' => $lonMatch[1] ?? 0
        ]);

        $statement = $this->connection->prepare(
            "INSERT INTO Event 
        (`eventId`, `organizeId`, `cover`, `morePics`, `title`, `description`, `venue`, `maximum`, `type`, `link`, `start`, `end`, `location`, `created`, `updated`)
        VALUES 
        (:eventId, :organizeId, :cover, :morePics, :title, :description, :venue, :maximum, :type, :link, :start, :end, :location, :created, :updated)"
        );

        $now = new DateTime();

        // Create Id -> AG
        // 25 : year
        // T : First character in Fname
        // 00000: Count

        $lastCols = $this->connection->prepare(
            "SELECT id FROM Event ORDER BY id DESC LIMIT 1"
        );

        $lastCols->execute();
        $getCols = $lastCols->fetchColumn();

        $newValue = ($getCols !== false) ? intval($getCols) + 1 : 1;
        $formattedValue = str_pad($newValue, 7, "0", STR_PAD_LEFT);

        $eventId = "AG-" . $now->format('Y') . $formattedValue . uniqid("_event-" . getRandomId(8));

        $statement->bindParam(':eventId', $eventId);
        $statement->bindParam(':organizeId', $_SESSION['user']['userId']);
        $statement->bindParam(':title', $data['title']);
        $statement->bindParam(':description', $data['description']);
        $statement->bindParam(':venue', $data['venue']);
        $statement->bindParam(':maximum', $data['maximum']);
        $statement->bindParam(':type', $data['type']);
        $statement->bindParam(':link', $data['link']);
        $statement->bindParam(':start', $started);
        $statement->bindParam(':start', $ended);
        $statement->bindParam(':location', $location);

        $statement->execute([
            ':eventId' => $eventId,
            ':organizeId' => $_SESSION['user']['userId'],
            ':cover' => $coverImage,
            ':morePics' => $more_pic,
            ':title' => $data['title'],
            ':description' => $data['description'],
            ':venue' => $data['venue'],
            ':maximum' => $data['maximum'] ?? 0,
            ':type' => $data['type'],
            ':link' => $data['link'],
            ':start' => $started,
            ':end' => $ended,
            ':location' => $location,
            ':created' => $now->format('Y-m-d H:i:s'),
            ':updated' => $now->format('Y-m-d H:i:s')
        ]);

        $result = $statement->fetch(PDO::FETCH_ASSOC);

        return [$result];
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

    // public function Registration(){
    //     $use = $_SESSION['user']['userId'];
    //     //เพิ่มเงื่อนไขว่าต้องมาจากeventไหนด้วย
    //     $statement = $this->connection->prepare("
    //         SELECT 	*
    //         FROM	Registration,User
    //         WHERE	Registration.userId = User.userId
    //         and     User.userId not like '$use'
    //         ");

    //     $statement->execute();
    //     $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    //     return $result;
    // }

    // public function inEvent(){
    //     $use = $_SESSION['user']['userId'];

    //     $statement = $this->connection->prepare("
    //         SELECT 	*
    //         FROM	Event,Attendance
    //         WHERE	Attendance.verifyBy = Event.organizeId
    //         and     Attendance.verifyBy not like '$use'
    //         ");

    //     $statement->execute();
    //     $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    //     return $result;
    // }

    // public function acc(){
    //     $sql = $this -> connection -> prepare("
    //         INSERT INTO Attendance value ('')
    //     ");
    // }

    public function getUsersByRegId($regId) {

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

        $now = new DateTime();

        // Bind the parameters
        $sql->bindParam(':eventId', $data['eventId']);
        $sql->bindParam(':organizeId', $_SESSION['userId']);
        $sql->bindParam(':title', $data['title']);
        $sql->bindParam(':description', $data['description']);
        $sql->bindParam(':venue', $data['venue']);
        $sql->bindParam(':maximum', $data['maximum']);
        $sql->bindParam(':type', $data['type']);
        $sql->bindParam(':link', $data['link']);

        $sql->execute([
            ':eventId' => $data['eventId'],
            ':organizeId' => $_SESSION['user']['userId'],
            // ':cover' => $coverImage,
            // ':morePics' => $more_pic,
            ':title' => $data['title'],
            ':description' => $data['description'],
            ':venue' => $data['venue'],
            ':maximum' => $data['maximum'],
            ':type' => $data['type'],
            ':link' => $data['link'],
            // ':start' => $started,
            // ':end' => $ended,
            // ':location' => $location,
            ':updated' => $now->format('Y-m-d H:i:s')
        ]);

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
            $title = $title;
            $dateStart = $dateStart;
            $dateEnd = $dateEnd;

            $query = "SELECT * FROM Event WHERE 1=1";
            $params = [];

            if (!empty($title)) {
                $query .= " AND title LIKE :title";
                $params[':title'] = "%$title%";
            }

            if (!empty($dateStart) && !empty($dateEnd)) {
                $query .= " AND (
                JSON_UNQUOTE(JSON_EXTRACT(started, '$[0]')) BETWEEN :dateStart AND :dateEnd
                OR JSON_UNQUOTE(JSON_EXTRACT(started, '$[1]')) BETWEEN :dateStart AND :dateEnd
            )";
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

    public function getRegistrationEventByUserId() {}

    public function deleteEventById() {}

    public function getmailbyid() {

    }
}
