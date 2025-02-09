<?php

namespace FinalProject;

require_once(__DIR__ . '/php/environment.php');
require_once(__DIR__ . '/controller/MainController.php');
require_once(__DIR__ . '/model/MapModel.php');

use FinalProject\Controller\MainController;

$action = $_GET['action'] ?? 'index';
$controller = new MainController();

$title = $controller->getTitle();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($title); ?></title>
</head>

<body>
    <?php
    switch ($action) {
        case 'index':
            $controller->index();
            break;
        default:
            header("HTTP/1.0 404 Not Found");
            echo "Page not found";
            break;
    }
    ?>
</body>

</html>