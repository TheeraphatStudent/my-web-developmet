<?php
$email = $_POST['email'];
$password = $_POST['password'];
$result = login( $email, $password);
print_r($_SESSION['timestamp']);
if($result){
    $unix_timestamp = time();
    $_SESSION['timestamp'] = $unix_timestamp;
    $_SESSION['student_id'] = $result['student_id'];
    renderView('main_get', $result);
}else{
    $_SESSION['message'] = 'Email or Password invalid';
    renderView('login_get');
    unset($_SESSION['message']);
    unset($_SESSION['timestamp']);
}


