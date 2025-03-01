<?php

namespace FinalProject\Model;

require_once(__DIR__ . '/../utils/useRandomize.php');

use PDO;

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
    public function getUserByUserId($userId)
    {
        $stmt = $this->connection->prepare("SELECT * FROM User WHERE userId = :userId");
        $stmt->execute([':userId' => $userId]);
        if ($stmt->fetchColumn() > 0) {
            return true;
        }
        return false;
    }

    public function register($username, $password, $email)
    {
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
    }
    public function login($username, $password)
    {
        $stmt = $this->connection->prepare('SELECT * FROM User WHERE username = :username');
        $stmt->execute([':username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        $result = null;

        if ($user && password_verify($password, $user['password'])) {
            $user = array_diff_key($user, array_flip(['username', 'password']));
            $result = $user['userId'];

            return $result;
        }

        return $result;
    }
}
