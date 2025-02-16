<?php


class Init
{
    private $connection;

    public function __construct()
    {
        $server = 'database';
        $user = 'final-activity';
        $password = '1212312121';
        $database = 'final-database';

        try {
            $dsn = "mysql:host=$server;dbname=$database;charset=utf8mb4";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];
            $this->connection = new PDO($dsn, $user, $password, $options);
        } catch (PDOException $e) {
            die('Database connection failed: ' . $e->getMessage());
        }
    }

    public function getConnected()
    {
        return $this->connection;
    }
}
