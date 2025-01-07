<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uniq_id = $_POST['uniq_id'];
    $stdid = $_POST["stdid"];
    $prefix = $_POST["prefix"];
    $name = $_POST["name"];
    $year = $_POST["year"];
    $grade = $_POST["grade"];
    $birthday = $_POST["birthday"];

    if (!isset($_SESSION["students"]) || empty($_SESSION["students"])) {
        $students = [];
    } else {
        $students = json_decode($_SESSION["students"], true);
    }

    $students[$uniq_id] = [
        "uniq_id" => $uniq_id,
        "stdid" => $stdid,
        "prefix" => $prefix,
        "name" => $name,
        "year" => $year,
        "grade" => $grade,
        "birthday" => $birthday
    ];

    $_SESSION["students"] = json_encode($students);
    header("Location:./index.php");
    exit;
}

