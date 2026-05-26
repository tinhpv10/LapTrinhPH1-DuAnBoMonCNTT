<?php

require_once 'controllers/HomeController.php';
require_once 'controllers/ProductController.php';

$action = isset($_GET['action']) ? $_GET['action'] : 'home';

switch ($action) {
    case 'home':
        $controller = new HomeController();
        $controller->index();
        break;

    case 'products':
        $controller = new ProductController();
        $controller->listProducts();
        break;

    case 'product-detail':
        $controller = new ProductController();
        $controller->detail();
        break;

    case 'forgot-password':
        include 'views/forgot-password.php';
        break;

    case 'profile':
        include 'views/profile.php';
        break;

    default:
        echo "404 - Trang không tồn tại!";
        break;
}