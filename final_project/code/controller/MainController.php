<?php

namespace FinalProject\Controller;

require_once(__DIR__ . '/AuthController.php');

use FinalProject\Controller\AuthController;
use FinalProject\Model\MapModel;
use FinalProject\Model\UserModel;

class MainController
{
    private $mapModel;
    private $userModel;

    public function __construct()
    {
        $this->mapModel = new MapModel();
        // $this->userModel = new UserModel();
    }

    public function index()
    {
        // $mapApiKey = $this->mapModel->getMapApiKey();
        require_once("./view/LandingView.php");
    }

    public function auth($type = 'login')
    {

        $auth = new AuthController();

        switch ($type) {
            case 'login':
                $auth->login();
                break;

            case 'register':
                $auth->register();
                break;

            case 'logout':
                $auth->logout();
                break;
        }
    }

    public function notFound() {
        header("HTTP/1.0 404 Not Found");
        require_once("./view/NotFoundView.php");

    }
}
