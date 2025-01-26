<?php

interface UserProps
{
    public function createAccount($username, $email, $password);
    public function validateUser($username, $password);
    public function validateToken($token);
}

class User implements UserProps
{
    private $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function createAccount($username, $email, $password)
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);

        try {
            $statement = $this->connection->prepare("INSERT INTO users (userId, username, email, password) VALUES (:userId, :username, :email, :password)");
            $statement->execute([
                ':userId' => bin2hex(random_bytes(64)),
                ':username' => $username,
                ':email' => $email,
                ':password' => $hash
            ]);

            $userId = $this->connection->lastInsertId();

            $statement = $this->connection->prepare("SELECT * FROM users WHERE id = :id");
            $statement->execute([':id' => $userId]);
            $user = $statement->fetch(PDO::FETCH_ASSOC);

            return $user;
        } catch (PDOException $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function validateUser($username, $password)
    {
        try {
            $statement = $this->connection->prepare("SELECT * FROM users WHERE username = :username");
            $statement->execute([':username' => $username]);

            $user = $statement->fetch(PDO::FETCH_ASSOC);

            if (!$user) {
                return ['status' => 404, 'error' => 'User not found'];
            }

            if (password_verify($password, $user['password'])) {
                unset($user['username']);
                unset($user['password']);
                unset($user['email']);

                return ['status' => 200, 'user' => $user];
            } else {
                return ['status' => 401, 'error' => 'Invalid password'];
            }
        } catch (PDOException $e) {
            return ['status' => 400, 'error' => $e->getMessage()];
        }
    }

    public function validateToken($token)
    {
        try {
            $statement = $this->connection->prepare("SELECT * FROM users WHERE userId = :userId");
            $statement->execute([':userId' => $token]);

            $user = $statement->fetch(PDO::FETCH_ASSOC);

            if (!$user) {
                return ['status' => 404, 'error' => 'User not found', 'valid' => false];
            }

            unset($user['username']);
            unset($user['password']);
            unset($user['email']);

            return ['status' => 200, 'valid' => true];
        } catch (PDOException $e) {
            return ['status' => 400, 'error' => $e->getMessage(), 'valid' => false];
        }
    }
}
