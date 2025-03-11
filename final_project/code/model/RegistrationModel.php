<?php

namespace FinalProject\Model;

require_once(__DIR__ . '/../utils/useResponse.php');
require_once(__DIR__ . '/../utils/useRandomize.php');

use FinalProject\Utils;

use DateTime;
use PDO;
use PDOException;


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

    // User ส่งคำขอมาที่ Reg table
    public function getUserRegisterByEventAndUserId($userId, $eventId)
    {
        $statement = $this->connection->prepare("CALL GetUsersRegByEventId(:userId, :eventId)");
        $statement->bindParam(':userId', $userId);
        $statement->bindParam(':eventId', $eventId);

        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public function acceptUserRegById($userId, $eventId, $regId, $authorId)
    {
        try {
            $this->connection->beginTransaction();

            $stmt = $this->connection->prepare("
                UPDATE Registration 
                SET status = 'accepted', updated = NOW()
                WHERE userId = :userId 
                AND eventId = :eventId
                AND regId = :regId
            ");

            $stmt->bindParam(':userId', $userId);
            $stmt->bindParam(':eventId', $eventId);
            $stmt->bindParam(':regId', $regId);

            $stmt->execute();

            if ($stmt->rowCount() === 0) {
                $this->connection->rollBack();
                return [
                    "status" => 401,
                    "isUpdate" => false,
                    "message" => "Something went wrong!"
                ];
            }

            // $author = $this->connection->prepare("
            //     SELECT a.id FROM Author a WHERE a.authorId = :authorId AND a.eventId = :eventId
            // ");

            // $author->bindParam(':authorId', $authorId);
            // $author->bindParam(':eventId', $eventId);
            // $author->execute();

            // if ($author->rowCount() === 0) {
            //     $this->connection->rollBack();
            //     return [
            //         "status" => 404,
            //         "isUpdate" => false,
            //         "message" => "คุณไม่ใช่ผู้มีส่วนร่วมในกิจกรรมนี้"
            //     ];
            // }

            // $authorId = ($author->fetch(PDO::FETCH_ASSOC))['id'];

            // Att table 
            $attendance = $this->connection->prepare("
                INSERT INTO `Attendance` (`regId`, `verifyBy`, `status`) 
                VALUES (:regId, :authorId, :status)
            ");

            $status = "pending";
            $attendance->bindParam(':regId', $regId);
            $attendance->bindParam(':authorId', $authorId);
            $attendance->bindParam(':status', $status);

            $attendance->execute();

            $this->connection->commit();

            return [
                "status" => 200,
                "isUpdate" => true,
                "message" => "เข้าร่วมกิจกรรมแล้ว"
            ];
        } catch (PDOException $e) {
            $this->connection->rollBack();
            return [
                "status" => 500,
                "isUpdate" => false,
                "message" => "เกิดข้อผิดพลาด: " . $e->getMessage()
            ];
        }
    }

    public function rejectRegistrationById($regId, $message)
    {
        try {
            $this->connection->beginTransaction();

            $sql = $this->connection->prepare("
                UPDATE Registration r
                JOIN Attendance a ON r.regId = a.regId
                SET 
                    r.status = 'reject',
                    a.status = 'reject',
                    a.rejectMessage = :message
                WHERE r.regId = :regId;
            ");

            $sql->bindParam(':message', $message);
            $sql->bindParam(':regId', $regId);

            $sql->execute();

            if ($sql->rowCount() === 0) {
                $this->connection->rollBack();
                return [
                    "status" => 500,
                    "message" => "Failed reject for this user."
                ];
            }

            $this->connection->commit();

            return [
                "status" => 200,
                "message" => "Reject completed"
            ];
        } catch (PDOException $err) {
            $this->connection->rollback();
            return [
                "status" => 500,
                "message" => $err,
            ];
        }
    }
}
