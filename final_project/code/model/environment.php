<?php

class environment
{
    private String $mapApiKey;

    public function __construct()
    {
        $this->mapApiKey = '55072ff6dc986c8484ea0615c17bf149';
    }

    public function getMapApiKey(): string
    {
        return $this->mapApiKey;
    }
    public function db()
    {
        $host = "localhost";
        $dbname = "my_database";
        $username = "root";
        $password = "";

        try {
            $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }
}
