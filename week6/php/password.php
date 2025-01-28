<?php
require_once(__DIR__ . '/../php/connected.php');
require_once(__DIR__ . '/../php/user.php');
require_once(__DIR__ . '/../utils/useHttpStatus.php');

$init = new Init();
$connection = $init->getConnected();

$user = new User($connection);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // print_r($_POST);

    $fields = ['username', 'email', 'password'];

    foreach ($fields as $field) {
        if (!isset($_POST[$field])) {
            $response = new HttpStatusResponse(400, "Missing required field!");
            $response->send();
        }
    }

    $result = $user->resetPassword($_POST['username'], $_POST['email'], $_POST['password']);

    if ($result['status'] === 200) {
        $response = new HttpStatusResponse($result['status'], $result['message']);
        $response->send();

    } else {
        $response = new HttpStatusResponse($result['status'], $result['error']);
        $response->send();

    }

    echo "<script>window.location.href = '../'</script>";
    exit;
}
