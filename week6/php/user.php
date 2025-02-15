<?php

interface UserProps
{
    public function createAccount($username, $email, $password);
    public function validateUser($username, $password);
    public function validateToken($token);
    public function resetPassword($username, $email, $newPassword);
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
                return ['status' => 404, 'error' => 'User not found', 'valid' => false, 'response' => $user];
            }

            unset($user['username']);
            unset($user['password']);
            unset($user['email']);

            return ['status' => 200, 'valid' => true];
        } catch (PDOException $e) {
            return ['status' => 400, 'error' => $e->getMessage(), 'valid' => false];
        }
    }

    public function resetPassword($username, $email, $newPassword)
    {
        try {
            $statement = $this->connection->prepare("SELECT * FROM users WHERE username = :username AND email = :email");
            $statement->bindParam(':username', $username);
            $statement->bindParam(':email', $email);
            $statement->execute();

            $user = $statement->fetch(PDO::FETCH_ASSOC);

            if (!$user) {
                return ['status' => 404, 'error' => 'User not found'];
            }

            $hash = password_hash($newPassword, PASSWORD_DEFAULT);

            $update = $this->connection->prepare("UPDATE users SET password = :password WHERE username = :username AND email = :email");
            $update->bindParam(':password', $hash);
            $update->bindParam(':username', $username);
            $update->bindParam(':email', $email);

            $update->execute(); 

            if ($update->rowCount() > 0) {
                return ['status' => 200, 'message' => 'Password reset successfully'];
            } else {
                return ['status' => 500, 'error' => 'Failed to reset password'];
            }
        } catch (PDOException $e) {
            return ['status' => 400, 'error' => 'Database error: ' . $e->getMessage()];
        }
    }
}
