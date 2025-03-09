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

    public function acceptUserById($userId, $verifyBy, $regId)
    {
        try {
            $stmt = $this->connection->prepare("
            UPDATE Attendance a
            JOIN Registration r ON a.regId = r.regId
            SET 
                a.status = 'accepted',
                a.verifyBy = :verifyBy
            WHERE r.userId = :userId
            AND r.regId = :regId
            ");

            $stmt->bindParam(':userId', $userId);
            $stmt->bindParam(':verifyBy', $verifyBy);
            $stmt->bindParam(':regId', $regId);

            if (!$stmt->execute()) {
                return [
                    "status" => 500,
                    "message" => "เกิดข้อผิดพลาด, ลองใหม่อีกครั้ง"
                ];
            }

            if (!$stmt->rowCount() === 0) {
                return [
                    "status" => 404,
                    "message" => "ไม่พบการขอเข้าร่วม!"
                ];

            }

            return [
                "status" => 200,
                "message" => "ดำเนินการเรียบร้อย"
            ];
        } catch (PDOException $err) {
            return [
                "status" => 500,
                "message" => "ติดต่อฐานข้อมูลล้มเหลว" . $err->getMessage() .", ติดต่อผู้พัฒนา"
            ];
        }
    }

    public function rejectUserById($userId) {}
}
