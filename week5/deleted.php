<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $stdid = $_POST["stdid"];

    if (isset($_SESSION["students"]) && !empty($_SESSION["students"])) {
        $students = json_decode($_SESSION["students"], true);

        if (isset($students[$stdid])) {
            unset($students[$stdid]);
        }

        $_SESSION["students"] = json_encode($students);
    }
}

header("Location: ./index.php");
exit;
?>