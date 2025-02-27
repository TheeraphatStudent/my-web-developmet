<?php

namespace FinalProject;

session_start();

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

const ALLOWED_REQUEST = ['type'];



// require_once(__DIR__ . '/php/environment.php');
require_once(__DIR__ . '/controller/MainController.php');

require_once(__DIR__ . '/model/MapModel.php');
require_once(__DIR__ . '/model/Environment.php');

require_once(__DIR__ . '/components/navbar.php');

use FinalProject\Model\Environment;
use FinalProject\Components\Navbar;
use FinalProject\Controller\MainController;

$action = $_GET['action'] ?? 'index';

$isRequest = false;
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

$env = new Environment();
$_SESSION['mapApiKey'] = $env->getMapApiKey();

// print_r($_SESSION);

switch ($action) {
    
    case 'request':
        // print_r($_SERVER['REQUEST_METHOD']);
        // print_r($_GET);
        // print_r($_POST);
        // localhost:3000/?action=request&method=post&on=auth&username=admin&password=admin&email=admin@example.com

        $isRequest = true;

        $input = json_decode(file_get_contents("php://input"), true) ?? [];
        $data = array_merge($_POST, $input);

        $response = $controller->request($_GET, $data);

        http_response_code($response['status']);

        if ($response['status'] != 200) {
            header('Location: ' . $response['redirect'] . '&status=' . $response['status']);
            exit;

        }

        header("Content-Type: application/json");
        echo json_encode($response);
        exit;
        // ================= Page Content ================= 

    case 'index':
        $controller->index();
        break;

    case 'login':
    case 'register':
    case 'logout':
        $controller->auth($action);
        
        break;

    case 'event.attendee':
    case 'event.create':
    case 'event.checked-in':
        $controller->event($action);
        break;

    case 'profile':
        $controller->profile();
        break;

    default:
        header("HTTP/1.0 404 Not Found");
        $controller->notFound();
        exit();
}

// ===== Content =====

$content = ob_get_clean();

$navbar = new Navbar();
print_r($_SESSION);

if(isset($_SESSION['userId'])){
    $controller->auth($action);
    $response = $controller->request(["on" => "user", "form" => "verify"], ["userId" => $_SESSION['userId']]);
    $navbar -> UpdateNavbar($response);
}
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
<?php

}
?>