<?php

namespace FinalProject\Model;

class Event
{
    private $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function createEvent($data = [])
    {
        $statement = $this->connection->prepare("INSERT INTO Event (`eventId`, `organizeId`, `cover`, `title`, `description`, `venue`, `maximum`, `type`, `link`, `start`, `end`, `location`, `created`, `updated`) VALUES (:eventId, :organizeId, :cover, :title, :description, :venue, :maximum, :type, :like, :start, :end, :location, :created, :updated) ");
    }
}
