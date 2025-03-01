<?php

namespace FinalProject\Model;

require_once(__DIR__ . '/../utils/useResponse.php');
require_once(__DIR__ . '/../utils/useImages.php');
require_once(__DIR__ . '/../utils/useRandomize.php');

use FinalProject\Utils;

use DateTime;
use PDO;

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

        $statement->execute([
            ':eventId' => $eventId,
            ':organizeId' => $_SESSION['userId'],
            ':cover' => $coverImage,
            ':morePics' => $more_pic,
            ':title' => $data['title'],
            ':description' => $data['description'],
            ':venue' => $data['venue'],
            ':maximum' => $data['maximum'],
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
        print_r($_SESSION);
        echo "<br>";
        print_r($data);

        // Prepare the SQL statement
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

        // Get the current timestamp
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

        // Execute the SQL statement
        $sql->execute([
            ':eventId' => $data['eventId'],
            ':organizeId' => $_SESSION['userId'],
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
        // Check if any rows were affected (i.e., the update was successful)
        $rowCount = $sql->rowCount();
        if ($rowCount > 0) {
            return ["It worked, $rowCount rows updated"];
        } else {
            return ["No rows updated, check the eventId or organizeId"];
        }
    }


    public function deleteEventById() {}
}
