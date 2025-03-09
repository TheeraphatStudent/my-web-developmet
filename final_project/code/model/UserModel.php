<?php

namespace FinalProject\Model;

require_once(__DIR__ . '/../utils/useRandomize.php');

use PDO;
use DateTime;
use PDOException;

class User
{
    // Create account
    // verify password

    private $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function getUserByUsername($username)
    {
        $stmt = $this->connection->prepare("SELECT * FROM User WHERE username = :username");
        $stmt->execute([':username' => $username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getUserByEmail($email)
    {
        $stmt = $this->connection->prepare("SELECT userId FROM User WHERE email = :email");
        $stmt->bindParam(':email', $email);

        $stmt->execute();

        return $stmt->fetchColumn() > 0;
    }

    public function getUserByUserId($userId)
    {
        $stmt = $this->connection->prepare("
            SELECT 
                u.username, 
                u.userId, 
                u.email, 
                u.name, 
                u.gender, 
                u.education, 
                u.telno, 
                u.birth, 
                u.created,
                COUNT(DISTINCT CASE WHEN r.status = 'accept' THEN r.regId END) AS total_events_joined,
                COUNT(DISTINCT e.eventId) AS total_events_created
            FROM User u
            LEFT JOIN Registration r ON u.userId = r.userId
            LEFT JOIN Event e ON u.userId = e.organizeId
            WHERE u.userId = :userId
            GROUP BY u.userId
        ");

        $stmt->bindParam(':userId', $userId, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            return ["isFound" => true, "user" => $user, "status" => 200];
        }

        return ["isFound" => false, "user" => [], "status" => 404];
    }


    public function register($username, $password, $email)
    {
        try {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $this->connection->prepare("INSERT INTO User (userId, username, password, email, created, updated) VALUES (:userId, :username, :password, :email, :created, :updated)");

            $lastCols = $this->connection->prepare(
                "SELECT id FROM User ORDER BY id DESC LIMIT 1"
            );

            $lastCols->execute();
            $getCols = $lastCols->fetchColumn();

            $newValue = ($getCols !== false) ? intval($getCols) + 1 : 1;
            $formattedValue = str_pad($newValue, 7, "0", STR_PAD_LEFT);

            $userId = "AGU-" . $formattedValue . uniqid("_user-" . getRandomId(8));

            $now = new DateTime();

            $stmt->execute([
                ':userId' => $userId,
                ':username' => $username,
                ':password' => $hashedPassword,
                ':email' => $email,
                ':created' => $now->format('Y-m-d H:i:s'),
                ':updated' => $now->format('Y-m-d H:i:s')
            ]);

            return [
                "status" => 201,
                "message" => "User registered successfully",
            ];
        } catch (PDOException $err) {
            return [
                "status" => 500,
                "message" => "Registration failed: " . $err->getMessage()
            ];
        }
    }

    public function login($username, $password)
    {
        $stmt = $this->connection->prepare('SELECT * FROM User WHERE username = :username');
        $stmt->bindParam(':username', $username);

        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        $result = null;

        if ($user && password_verify($password, $user['password'])) {
            $user = array_diff_key($user, array_flip(['username', 'password']));
            $result = $user['userId'];
        }

        return $result;
    }

    public function isUserProfileVerify($userId)
    {
        try {
            $sql = $this->connection->prepare("
        SELECT 
            CASE 
                WHEN 
                    u.name IS NULL 
                    OR u.gender IS NULL 
                    OR u.education IS NULL 
                    OR u.telno IS NULL 
                    OR u.birth IS NULL 
                    THEN FALSE
                ELSE TRUE 
            END AS isVerify
        FROM User u
        WHERE u.userId = :userId;
        ");

            $sql->bindParam(':userId', $userId, PDO::PARAM_STR);

            $sql->execute();

            $isVerify = $sql->fetch(PDO::FETCH_ASSOC);

            if ($isVerify['isVerify'] === 1) {
                return [
                    "status" => 200,
                    "message" => "ผู้ใช้ยืนยันตัวตนเรียบร้อย",
                    "isVerify" => true
                ];
            } else {
                return [
                    "status" => 403,
                    "message" => "ยังไม่ได้ยืนยันตัวตน",
                    "isVerify" => false
                ];
            }
        } catch (PDOException $err) {
            return [
                "status" => 500,
                "message" => "Error: " . $err,
                "isVerify" => false
            ];
        }
    }

    public function updateUserById(array $data)
    {
        try {
            $this->connection->beginTransaction();

            $checkUserStmt = $this->connection->prepare("SELECT u.username FROM User u WHERE u.userId = :userId");
            $checkUserStmt->bindParam(':userId', $data['userId'], PDO::PARAM_STR);
            $checkUserStmt->execute();

            $user = $checkUserStmt->fetch(PDO::FETCH_ASSOC);

            if (!$user) {
                $this->connection->rollBack();
                return [
                    "status" => 404,
                    "message" => "User not found"
                ];
            }

            $sql = $this->connection->prepare("
            UPDATE User 
            SET 
                username = :username,
                email = :email,
                name = :name,
                gender = :gender,
                telno = :telno,
                birth = :birth,
                education = :education,
                updated = :updated
            WHERE userId = :userId
            ");

            $now = (new DateTime())->format('Y-m-d H:i:s');
            $username = $data['username'] ?? $user['username'];

            $sql->bindParam(':username', $username, PDO::PARAM_STR);
            $sql->bindParam(':userId', $data['userId'], PDO::PARAM_STR);
            $sql->bindParam(':email', $data['email'], PDO::PARAM_STR);
            $sql->bindParam(':name', $data['name'], PDO::PARAM_STR);
            $sql->bindParam(':gender', $data['gender'], PDO::PARAM_STR);
            $sql->bindParam(':telno', $data['telno'], PDO::PARAM_STR);
            $sql->bindParam(':birth', $data['birth'], PDO::PARAM_STR);
            $sql->bindParam(':education', $data['education'], PDO::PARAM_STR);
            $sql->bindParam(':updated', $now, PDO::PARAM_STR);

            $sql->execute();

            $this->connection->commit();

            return [
                "status" => 200,
                "message" => "User updated successfully: " . $sql->fetch(PDO::FETCH_ASSOC)
            ];
        } catch (PDOException $err) {
            $this->connection->rollBack();
            return [
                "status" => 500,
                "message" => "Error: " . $err->getMessage()
            ];
        }
    }

    public function resetPassword($username, $email, $newPassword) {
        try {
            $this->connection->beginTransaction();
            
            $stmt = $this->connection->prepare("
                SELECT userId
                FROM User 
                WHERE username = :username 
                AND email = :email
            ");
            
            $stmt->execute([
                ':username' => $username,
                ':email' => $email
            ]);
            
            if (!$stmt->fetch()) {
                $this->connection->rollBack();
                return [
                    "status" => 404,
                    "message" => "ไม่พบผู้ใช้งาน"
                ];
            }

            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $updateStmt = $this->connection->prepare("
                UPDATE User 
                SET password = :password,
                    updated = :updated
                WHERE username = :username 
                AND email = :email
            ");

            $now = (new DateTime())->format('Y-m-d H:i:s');
            
            $updateStmt->execute([
                ':password' => $hashedPassword,
                ':updated' => $now,
                ':username' => $username,
                ':email' => $email
            ]);

            $this->connection->commit();
            return [
                "status" => 200,
                "message" => "รหัสผ่านถูกเปลี่ยนแปลงเรียบร้อย"
            ];
            
        } catch (PDOException $err) {
            $this->connection->rollBack();
            return [
                "status" => 500, 
                "message" => "เกิดข้อผิดพลาด: " . $err->getMessage()
            ];
        }
    }
}
