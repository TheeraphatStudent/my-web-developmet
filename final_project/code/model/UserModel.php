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
        $stmt->execute([':email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getUserByUserId($userId)
    {
        $stmt = $this->connection->prepare("
        SELECT u.username, u.userId, u.email, u.name, u.gender, u.education, u.telno, u.birth 
        FROM User u 
        WHERE u.userId = :userId
    ");
        $stmt->execute([':userId' => $userId]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            return ["isFound" => true, "user" => $user, "status" => 200];
        }

        return ["isFound" => false, "user" => [], "status" => 404];
    }


    public function register($username, $password, $email)
    {
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

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user;
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

            return $result;
        }

        return $result;
    }

    public function isUserProfileVerify($userId)
    {
        try {
            $sql = $this->connection->prepare("
        SELECT 
            CASE 
                WHEN u.name IS NULL 
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

            $sql->bindParam(':userId', $userId);

            $sql->execute();
            $isVerify = $sql->fetch(PDO::FETCH_ASSOC);

            if ($isVerify) {
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
}
