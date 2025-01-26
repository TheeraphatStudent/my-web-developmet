<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uniq_id = $_POST["uniq_id"];

    if (isset($_SESSION["students"]) && !empty($_SESSION["students"])) {
        $students = json_decode($_SESSION["students"], true);

        if (isset($students[$uniq_id])) {
            unset($students[$uniq_id]);
        }

        $_SESSION["students"] = json_encode($students);
    }
}

header("Location: ../pages/view.php");
exit;
?>