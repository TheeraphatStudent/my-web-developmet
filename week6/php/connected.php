<?php

interface InitProps
{
    public function closed();
    public function getConnected();
}

class Init implements InitProps
{
    private $connection;

    public function __construct()
    {
        $server = 'database';
        $user = 'week6';
        $password = '123456';
        $database = 'week6-database';

        try {
            $dsn = "mysql:host=$server;dbname=$database;charset=utf8mb4";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];
            $this->connection = new PDO($dsn, $user, $password, $options);
            // echo 'Connected Successfully';
        } catch (PDOException $e) {
            die('Database connection failed: ' . $e->getMessage());
        }
    }

    public function closed()
    {
        $this->connection = null;
    }

    public function getConnected()
    {
        return $this->connection;
    }
}
