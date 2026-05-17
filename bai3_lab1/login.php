<?php
session_start();
$username = $_POST['username'];
$password = $_POST['password'];

if ($username === 'admin' && $password == '123') {
    $_SESSION['is_logged_in'] = true;
    $_SESSION['username'] = $username;
    header('Location: home.php');
   
}else {
    echo 'Đăng nhập thất bại!';
}