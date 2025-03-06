<?php

namespace FinalProject\Model;

require_once(__DIR__ . '/../utils/useResponse.php');
require_once(__DIR__ . '/../utils/useRandomize.php');

use FinalProject\Utils;

use DateTime;
use PDO;
use PDOException;

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
        try {
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

            if ($result) {
                return ["data" => $result, "status" => 200];
            } else {
                return ["data" => [], "status" => 404];
            }
        } catch (PDOException $err) {
            return ["error" => $err, "data" => [], $status => 500];
        }
    }

    public function getRegisterById($userId, $eventId)
    {
        try {
            $stmt = $this->connection->prepare("
            SELECT * FROM Registration 
            WHERE userId = :userId AND eventId = :eventId
        ");

            $stmt->bindParam(':userId', $userId);
            $stmt->bindParam(':eventId', $eventId);

            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return [
                "status" => $result ? 200 : 404,
                "data" => $result ?: []
            ];
        } catch (PDOException $e) {
            return [
                "status" => 500,
                "error" => "Database error: " . $e->getMessage()
            ];
        }
    }

    public function getUserRegisterByEventAndUserId($userId, $eventId)
    {
        $statement = $this->connection->prepare("CALL GetUsersRegByEventId(:userId, :eventId)");
        $statement->bindParam(':userId', $userId);
        $statement->bindParam(':eventId', $eventId);

        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public function acceptUserRegById($userId, $eventId, $regId)
    {
        try {
            $stmt = $this->connection->prepare("UPDATE Registration 
                    SET status = 'accepted', updated = NOW()
                    WHERE userId = :userId AND eventId = :eventId AND regId = :regId AND status = 'pending'");
            $stmt->bindParam(':userId', $userId);
            $stmt->bindParam(':eventId', $eventId);
            $stmt->bindParam(':regId', $regId);

            $stmt->execute();

            return [
                "status" => ($stmt->rowCount() > 0) ? 200 : 401,
                "isUpdate" => ($stmt->rowCount() > 0) ? true : false
            ];
        } catch (PDOException $e) {
            [
                "status" => 500,
                "isUpdate" => false
            ];
        }
    }

    public function rejectRegistrationById($userId, $eventId, $regId) {
        
    }
}
