<?php

// validate user
// ...

namespace FinalProject;

const ALLOWED_REQUEST = ['type'];

// require_once(__DIR__ . '/php/environment.php');
require_once(__DIR__ . '/controller/MainController.php');
require_once(__DIR__ . '/controller/RequestController.php');
require_once(__DIR__ . '/model/MapModel.php');
require_once(__DIR__ . '/components/navbar.php');

use FinalProject\Components\Navbar;
use FinalProject\Controller\MainController;
use FinalProject\Controller\RequestController;

$action = $_GET['action'] ?? 'index';

$request = null;
$response = null;

// action = [page], request

// type: get, post, put, delete
// on: env, user, event,
// id: id ของข้อมูล เช่น userId, eventId, ..., envId

// ตัวอย่าง - ทั้งหมด
// localhost:3000/?action=request&type=get&on=env - ขอข้อมูล Environment ทั้งหมด
// localhost:3000/?action=request&type=get&on=users - ขอข้อมูล User ทั้งหมด

// ตัวอย่าง - ข้อมูลเฉพาะเจาะจง
// localhost:3000/?action=request&type=post&on=auth - เช็ค User โดยแนบข้อมูลเข้าไปใน body

// action : serve page,
// request : user ขอการดำเนินการบางอย่าง เช่น Verify Account, Get Environment Variables
// response : ตอบกลับคำขอ

$controller = new MainController();

// ob_start();

switch ($action) {
    case 'request':
        // $controller->request($type, $on, $id);
        break;

    case 'index':
        $controller->index();
        break;

    case 'login':
    case 'register':
    case 'logout':
        $controller->auth($action);
        break;

    case 'attendee':
        $controller->attendee();
        break;

    case 'profile':
        $controller->profile();
        break;

    default:
        header("HTTP/1.0 404 Not Found");
        $controller->notFound();
        exit();
}

$content = ob_get_clean();

$navbar = new Navbar();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" type="image/x-icon" href="public/images/logo.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Act gate</title>
</head>

<body>
    <?php
    if (!in_array($action, ['login', 'register', 'logout'])) {
        $navbar->render();
    }

    $content
    ?>
</body>

</html>