<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
?>

<?php
require_once "Views/layouts/header.php";
require_once "Controllers/DashboardController.php";
require_once "Controllers/ProductController.php";

if (!isset($_GET['pages'])) {
    $controller = new DashboardController();
    $controller->renderGiaoDienDashboard();
} else {
    switch ($_GET['pages']) {
        case "san-pham":
            if (isset($_GET['action']) && $_GET['action'] == "them") {
                $controller = new ProductController();
                $controller->renderGiaoDienThemSanPham();
            } else {
                $controller = new ProductController();
                $controller->renderGiaoDienSanPham();
            }



            break;


        default:
            $controller = new DashboardController();
            $controller->renderGiaoDienDashboard();
    }
}


require_once "Views/layouts/footer.php"
?>