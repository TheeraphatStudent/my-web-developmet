<?php

namespace FinalProject\Model;

require_once(__DIR__ . '/../utils/useResponse.php');

use FinalProject\Utils;

use DateTime;
use PDO;
use PDOException;


class Author
{
    private $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function getAuthorId($userId, $eventId)
    {
        try {
            $author = $this->connection->prepare("
                SELECT a.id FROM Author a WHERE a.authorId = :authorId AND a.eventId = :eventId
            ");

            $author->bindParam(':authorId', $userId);
            $author->bindParam(':eventId', $eventId);

            if (!$author->execute()) {
                return ["status" => 404, "message" => "เกิดข้อผิดพลาดไม่ทราบสาเหตุ", "authorId" => -1];
            }

            if (!$author->rowCount() === 0) {
                return ["status" => 404, "message" => "คุณไม่ได้มีส่วนร่วมในกิจกรรมนี้", "authorId" => -1];
            }

            $authorId = $author->fetch(PDO::FETCH_ASSOC);

            return [
                "status" => 200,
                "message" => "Get author work!",
                "authorId" => $authorId['id']

            ];
        } catch (PDOException $err) {
            return [
                "status" => 500,
                "message" => "Database Error: " . $err->getMessage(),
                "authorId" => -1

            ];
        } catch (\Throwable $th) {
            return [
                "status" => 500,
                "message" => "Error: " . $th->getMessage(),
                "authorId" => -1

            ];
        }
    }
}
