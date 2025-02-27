<?php

namespace FinalProject\Model;

use PDO;
// session_start();

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
            ':password' => $hashedPassword]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user;
    }
    public function login($username, $password){
        $stmt = $this->connection->prepare('SELECT * FROM User WHERE username = :username');
        $stmt ->execute([':username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        // print_r($user);
        if($user&&password_verify($password, $user['password'])){
            unset($user['username']);
            unset($user['password']);
            $userid = $user['userId'];
            $_SESSION['userid'] = $userid;
            return $userid;
        }
        // return $user;
    }
}
