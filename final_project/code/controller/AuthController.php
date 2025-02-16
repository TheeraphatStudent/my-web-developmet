<?php

namespace FinalProject\Controller;

class AuthController {
    public function login() {
        require_once("./view/auth/LoginView.php");
        
    }
    
    public function register() {
        require_once("./view/auth/RegisterView.php");
        
    }

    public function logout() {

    }

}