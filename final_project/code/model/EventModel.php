<?php

namespace FinalProject\Model;

require_once(__DIR__ . '/../utils/useResponse.php');
require_once(__DIR__ . '/../utils/useImages.php');

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

        $statement->execute([
            ':eventId' => bin2hex(random_bytes(64)),
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

    public function getEventById() {}

    public function updateEventById() {}

    public function deleteEventById() {}
}
