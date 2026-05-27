
<?php
// ✅ PHẢI để session_start() ĐẦU TIÊN - trước mọi output
session_start();
 
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
 
require_once "Controllers/HomeController.php";
require_once "Controllers/ProductController.php";
require_once "Controllers/UserController.php";
require_once "Controllers/OrderController.php";
require_once "Controllers/CartController.php";
 
require "Views/layouts/header.php";
 
if (isset($_GET['pages']) && !empty($_GET['pages'])) {
 
    switch ($_GET['pages']) {
 
        case "home":
            $controller = new HomeController();
            $controller->renderGiaoDien();
            break;
 
        case "chi-tiet-san-pham":
            require "Views/pages/product-detail.php";
            break;
 
        case "san-pham":
            require "Views/pages/products.php";
            break;
 
        case "gio-hang":
            require "Views/pages/cart.php";
            break;
 
        case "thanh-toan":
            require "Views/pages/checkout.php";
            break;
 
        case "dang-nhap":
            require "Views/pages/login.php";
            break;
 
        case "dang-ky":
            require "Views/pages/register.php";
            break;
 
        case "quen-mat-khau":
            require "Views/pages/forgot-password.php";
            break;
 
        case "ho-so":
            require "Views/pages/profile.php";
            break;
 
        case "dang-xuat":
            // Xử lý đăng xuất
            session_destroy();
            header('Location: ?pages=home');
            exit;
 
        default:
            echo "<h2 style='text-align:center; margin-top:50px;'>404 - Trang không tồn tại</h2>";
            break;
    }
 
} else {
 
    $controller = new HomeController();
    $controller->renderGiaoDien();
 
}
 
require "Views/layouts/footer.php";
?>