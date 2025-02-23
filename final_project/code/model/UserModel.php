<?php

namespace FinalProject\Model;

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

    public function register($username, $password)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->connection->prepare("INSERT INTO User (userId, username, password) VALUES (:userId, :username, :password)");
        $stmt->execute([
            ':userId' => bin2hex(random_bytes(64)),
            ':username' => $username,
            ':password' => $hashedPassword
        ]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user;
    }
}
