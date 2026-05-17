<?php
session_start();

if(!isset($_SESSION['í_logged_in']) || !$_SESSION['is_logged_in']){
    header('Location: login.php');
} else{
    echo 'Chào mừng' . $_SESSION['username']. '!';
}