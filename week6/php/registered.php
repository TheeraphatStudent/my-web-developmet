<?php
require_once(__DIR__ . '/connected.php');
require_once('../utils/useHttpStatus.php');
require_once(__DIR__ . '/user.php');

session_start();

$init = new Init();
$connection = $init->getConnected();

// PDO Statement to fetch all users from the database
// $statement = $connection->query('SELECT * FROM users');
// $allUsers = $statement->fetchAll(PDO::FETCH_ASSOC);

// print_r($allUsers);

$user = new User($connection);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

    if (strcasecmp($contentType, 'application/json') == 0) {
        $rawData = file_get_contents('php://input');
        $data = json_decode($rawData, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $response = new HttpStatusResponse(400, 'Invalid JSON', $rawData);
            $response->send();
            exit;
        }
    } else {
        $data = $_POST;
    }

    // Checked
    if (!isset($data['username']) || !isset($data['email']) || !isset($data['password'])) {
        $response = new HttpStatusResponse(400, 'Missing required fields', $data);
        $response->send();
        exit;
    }

    $result = $user->createAccount($data['username'], $data['email'], $data['password']);

    if (isset($result['error'])) {
        $response = new HttpStatusResponse(500, 'Error creating account', $result['error']);
    } else {
        $response = new HttpStatusResponse(201, 'Account created successfully', $result);
    }

    $response->send();
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

    if (strcasecmp($contentType, 'application/json') == 0) {
        $rawData = file_get_contents('php://input');
        $data = json_decode($rawData, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $response = new HttpStatusResponse(400, 'Invalid JSON', $rawData);
            $response->send();
            exit;
        }
    } else {
        $data = $_GET;
    }

    if (!isset($data['username']) || !isset($data['password'])) {
        $response = new HttpStatusResponse(400, 'Missing username or password');
        $response->send();
        exit;
    }

    $result = $user->validateUser($data['username'], $data['password']);
    // print_r($result);

    // $response = new HttpStatusResponse($result['status'], 'User validated successfully');
    // $response->send();

    if (isset($result['error'])) {
        header('Location: ../');
        exit;
    } else {
        $data = $result['user'];
        // print_r($data['userId']);

        $_SESSION['token'] = $data['userId'];
        header('Location: ../pages/view.php');

        exit;
    }
}
