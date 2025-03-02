<?php

namespace FinalProject\Model;

require_once(__DIR__ . '/../utils/useResponse.php');
require_once(__DIR__ . '/../utils/useRandomize.php');

use FinalProject\Utils;

use DateTime;
use PDO;

/* 
CREATE TABLE Registration (
  `id`        int AUTO_INCREMENT PRIMARY KEY,
  `regId`     varchar(255) NOT NULL UNIQUE,
  `eventId`   varchar(255) NOT NULL,
  `userId`    varchar(255) NOT NULL,
  `status`    varchar(100),
  `updated`   timestamp,
  `created`   timestamp
);

*/

class Registration
{

    private $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function registerEvent($userId, $eventId)
    {
        /*
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->connection->prepare("INSERT INTO User (userId, username, password, email) VALUES (:userId, :username, :password, :email)");

        $lastCols = $this->connection->prepare(
            "SELECT id FROM User ORDER BY id DESC LIMIT 1"
        );

        $lastCols->execute();
        $getCols = $lastCols->fetchColumn();

        $newValue = ($getCols !== false) ? intval($getCols) + 1 : 1;
        $formattedValue = str_pad($newValue, 7, "0", STR_PAD_LEFT);

        $userId = "AGU-". $formattedValue . uniqid("_user-" . getRandomId(8));

        $stmt->execute([
            ':userId' => $userId,
            ':username' => $username,
            ':password' => $hashedPassword,
            ':email' => $email,
        ]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user;
        */

        $lastCols = $this->connection->prepare(
            "SELECT id FROM Registration ORDER BY id DESC LIMIT 1"
        );

        $lastCols->execute();
        $getCols = $lastCols->fetchColumn();

        $newValue = ($getCols !== false) ? intval($getCols) + 1 : 1;
        $formattedValue = str_pad($newValue, 7, "0", STR_PAD_LEFT);

        $now = new DateTime();

        $regId = "AGR-" . $formattedValue . uniqid("_reg-" . getRandomId(8));

        // Status : pending, accept, reject

        $stmt = $this->connection->prepare("INSERT INTO Registration (regId, eventId, userId, status, created, updated) VALUES (:regId, :eventId, :userId, :status, :created, :updated)");

        $status = "pending";
        $now = new DateTime();
        $created = $now->format('Y-m-d H:i:s');
        $updated = $now->format('Y-m-d H:i:s');

        $stmt->bindParam(':regId', $regId);
        $stmt->bindParam(':eventId', $eventId);
        $stmt->bindParam(':userId', $userId);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':created', $created);
        $stmt->bindParam(':updated', $updated);

        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        // print_r($result);

        return [$result];
    }
}
