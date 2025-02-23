<?php

namespace FinalProject\Controller;

require_once(__DIR__ . '/AuthController.php');

use FinalProject\Controller\AuthController;
use FinalProject\Model\MapModel;

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

    // public function login()
    // {
    //     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //         $username = $_POST['username'] ?? '';
    //         $password = $_POST['password'] ?? '';
    //         if ($this->userModel->authenticate($username, $password)) {
    //             $_SESSION['user'] = $username;
    //             header('Location: index.php');
    //             exit;
    //         } else {
    //             $error = 'Invalid username or password';
    //         }
    //     }
    //     $this->renderView('LoginView', ['error' => $error ?? null]);
    // }

    // public function register()
    // {
    //     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //         $username = $_POST['username'] ?? '';
    //         $password = $_POST['password'] ?? '';
    //         $email = $_POST['email'] ?? '';
    //         if ($this->userModel->register($username, $password, $email)) {
    //             // Successful registration
    //             $_SESSION['user'] = $username;
    //             header('Location: index.php');
    //             exit;
    //         } else {
    //             $error = 'Registration failed';
    //         }
    //     }

    //     $this->renderView('RegisterView', ['error' => $error ?? null]);
    // }

    // public function logout()
    // {
    //     session_destroy();
    //     header('Location: index.php');
    //     exit;
    // }
}
