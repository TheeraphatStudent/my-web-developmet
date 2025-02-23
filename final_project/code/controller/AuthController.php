<?php

namespace FinalProject\Controller;

use PDO;
use FinalProject\Model\Environment;

class AuthController {
    private $pdo;

    public function login() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = trim($_POST["username"]);
            $password = $_POST["password"];

            $stmt = $this->pdo->prepare("SELECT id, password FROM user WHERE username = ?");
            $stmt->execute([$username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user["password"])) {
                session_start();
                $_SESSION["user_id"] = $user["id"];
                header("Location: /view/mapView.php");
                exit;
            } else {
                echo "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง!";
            }
        }

        require_once("./view/auth/LoginView.php");
        
    }
    
    public function register() {
        require_once("./view/auth/RegisterView.php");
        
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT); // เข้ารหัสรหัสผ่าน

    $stmt = $pdo->prepare("SELECT id FROM user WHERE username = ?");
    $stmt->execute([$username]);
    if ($stmt->rowCount() > 0) {
        echo "Username นี้ถูกใช้งานแล้ว!";
        exit;
    }

    $stmt = $pdo->prepare("INSERT INTO Users (username, password) VALUES (?, ?)");
    if ($stmt->execute([$username, $password])) {
        
    } else {
        
    }
}
    }

    public function logout() {

    }
    
}