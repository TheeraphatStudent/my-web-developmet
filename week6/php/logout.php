<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();
    
    if (isset($_SESSION['token'])) {
        unset($_SESSION['token']);
    }
    
    header('Location: ../');
    exit;

}