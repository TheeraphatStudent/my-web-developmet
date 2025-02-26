<?php

namespace FinalProject\Model;
use PDO;
use PDOException;

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
            $options = array(
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            );
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
