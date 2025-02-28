<?php

namespace FinalProject\Model;

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

        // print_r($data);

        $started = json_encode($data['start']);
        $ended = json_encode($data['end']);
        // $authors = json_encode($data['authors']);
        $more_pic = json_encode($data['more_pic']);

        $latMatch = 0;
        $lonMatch = 0;

        preg_match('/lat=([^&]*)/', $data['location'], $latMatch);
        preg_match('/lon=([^&]*)/', $data['location'], $lonMatch);

        $location = json_encode([
            'lat' => $latMatch[1],
            'lon' => $lonMatch[1]
        ]);

        $statement = $this->connection->prepare(
            "INSERT INTO Event 
            (`eventId`, `organizeId`, `cover`, `morePics`, `title`, `description`, `venue`, `maximum`, `type`, `link`, `start`, `end`, `location`, `created`, `updated`)
            VALUES 
            (:eventId, :organizeId, :cover, :morePics, :title, :description, :venue, :maximum, :type, :link, :start, :end, :location, :created, :updated)
            "
        );

        $statement->bindParam(':cover', $data['cover']);
        $statement->bindParam(':morePics', $more_pic);
        $statement->bindParam(':title', $data['title']);
        $statement->bindParam(':description', $data['description']);
        $statement->bindParam(':maximum', $data['maximum']);
        $statement->bindParam(':type', $data['type']);
        $statement->bindParam(':link', $data['link']);
        $statement->bindParam(':start', $started);
        $statement->bindParam(':end', $ended);
        $statement->bindParam(':location', $location);

        $now = new DateTime();

        $statement->execute([
            ':eventId' => bin2hex(random_bytes(64)),
            ':organizeId' => $_SESSION['userId'],
            ':cover' => $data['cover'],
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

    // ...
}
