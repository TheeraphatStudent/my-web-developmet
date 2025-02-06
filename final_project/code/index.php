<?php

namespace FinalProject;

require_once(__DIR__ . '/php/environment.php');
require_once(__DIR__ . '/controller/MapController.php');
require_once(__DIR__ . '/model/MapModel.php');

use FinalProject\Controller\MapController;

$action = $_GET['action'] ?? 'index';
$controller = new MapController();

switch ($action) {
    case 'index':
        $controller->index();
        break;
    default:
        header("HTTP/1.0 404 Not Found");
        echo "Page not found";
        break;
}
