<?php

require_once(__DIR__ .  '/student.php');
require_once('../utils/useHttpStatus.php');
require_once(__DIR__ .  '/connected.php');

$init = new Init();
$connection = $init->getConnected();

$student = new Student($connection);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $response = null;
    $result = null;

    switch (true) {
        case isset($_POST['update']):
            unset($_POST['update']);

            $result = $student->updateStudentByUniqId($_POST['uniq_id'], $_POST);
            break;

        case isset($_POST['post']):
            unset($_POST['post']);
            $result = $student->addedStudent($_POST);
            break;

        case isset($_POST['delete']):
            unset($_POST['delete']);
            $result = $student->removeStudentByUniqId($_POST['uniq_id']);
            break;

        default:
            $result = ['status' => 400, 'error' => 'Invalid operation'];
            break;
    }

    if (isset($result['error'])) {
        $response = new HttpStatusResponse(
            $result['status'],
            $result['error']
        );
    } else {
        $response = new HttpStatusResponse(
            $result['status'],
            $result['message'],
            $result['data'] ?? $_POST['uniq_id'] ?? null
        );
    }

    $response->send();

    echo "<script>window.location.href = '../pages/view.php';</script>";
    exit;
}