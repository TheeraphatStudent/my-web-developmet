<?php

namespace FinalProject\Model;

use DateTime;

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

        $started = json_encode($data['start']);
        $ended = json_encode($data['end']);
        $authors = json_encode($data['authors']);
        $more_pic = json_encode($data['more_pic']);

        $latMatch = 0;
        $lonMatch = 0;

        preg_match('/lat=([^&]*)/', $data['location'], $latMatch);
        preg_match('/lon=([^&]*)/', $data['location'], $lonMatch);

        $location = json_encode([
            'lat' => $latMatch[1],
            'lon' => $lonMatch[1]
        ]);


        // print_r("Create Event Work!");
        $statement = $this->connection->prepare(
            "INSERT INTO Event 
            (`eventId`, `organizeId`, `cover`, `morePics`, `title`, `description`, `venue`, `maximum`, `type`, `link`, `start`, `end`, `location`, `created`, `updated`)
            VALUES 
            (:eventId, :organizeId, :cover, :morePics, :title, :description, :venue, :maximum, :type, :like, :start, :end, :location, :created, :updated)
            "
        );

        $statement->bindParam($data['cover'], ':cover');
        $statement->bindParam($more_pic, ':morePics');
        $statement->bindParam($data['title'], ':title');
        $statement->bindParam($data['description'], ':description');
        $statement->bindParam($data['maximum'], ':maximum');
        $statement->bindParam($data['type'], ':type');
        $statement->bindParam($data['link'], ':link');
        $statement->bindParam($started, ':start');
        $statement->bindParam($ended, ':end');
        $statement->bindParam($location, ':location');

        $statement->execute([
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
            ':created' => new DateTime(),
            ':updated' => new DateTime()
        ]);

        


        return [];
    }
}
