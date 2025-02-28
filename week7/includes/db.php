<?php

function getConnection():mysqli
{
    $hostname = 'localhost';
    $dbName = 'enrollment';
    $username = 'demo';
    $password = '1234';
    $conn = new mysqli($hostname, $username, $password, $dbName);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}

require_once DATABASE_DIR . '/students.php';
require_once DATABASE_DIR . '/authen.php';
require_once DATABASE_DIR . '/courses.php';
require_once DATABASE_DIR . '/enrollments.php';