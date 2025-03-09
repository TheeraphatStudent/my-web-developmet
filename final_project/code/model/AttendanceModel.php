<?php

namespace FinalProject\Model;

require_once(__DIR__ . '/../utils/useResponse.php');
require_once(__DIR__ . '/../utils/useRandomize.php');

use FinalProject\Utils;

use DateTime;
use PDO;
use PDOException;


class Attendance
{

    private $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function getUserWasAcceptRegOnEventById($userId, $eventId)
    {
        try {
            $stmt = $this->connection->prepare("CALL GetUserAttendanceOnEvent(:userId, :eventId)");

            $stmt->bindParam(':userId', $userId);
            $stmt->bindParam(':eventId', $eventId);

            if (!$stmt->execute()) {
                return [];
            }

            $att = $stmt->fetch(PDO::FETCH_ASSOC);

            return $att;

        } catch (PDOException $err) {
            return [];
        }
    }
}
