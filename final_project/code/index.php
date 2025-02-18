<?php

namespace FinalProject;

use FinalProject\Controller\MainController;

// require_once(__DIR__ . '/php/environment.php');
require_once(__DIR__ . '/controller/MainController.php');
require_once(__DIR__ . '/model/MapModel.php');

$action = $_GET['action'] ?? 'index';
// action : Page
// request : user ขอการดำเนินการบางอย่าง เช่น Lonin

$controller = new MainController();

// ob_start();

switch ($action) {
    case 'index':
        $controller->index();
        break;

    case 'login':
    case 'register':
    case 'logout':
        $controller->auth($action);
        break;

    default:
        header("HTTP/1.0 404 Not Found");
        $controller->notFound();
        exit();
}

$content = ob_get_clean();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Act gate</title>
</head>

<body>
    <?php
    $content
    ?>
</body>

</html>