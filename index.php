<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once "Models/Database.php";
$db = new Database();
$pdo = $db->connect();


// $sql = "SELECT * FROM `products`;";
// $stmt = $pdo->query($sql);
// $rows = $stmt->fetchAll();
// var_dump($rows);























die;
// đường dẫn dùng $_GET
// domain.com?name=Tính&age=18&address=Cần%20Thơ
// $_GET['name'] giá trị sẽ là Tính
// $_GET['age'] giá trị sẽ là 18
// $_GET['address'] giá trị sẽ là Cần Thơ
// echo $_GET['address'];
require_once "Controllers/HomeController.php";
require_once "Controllers/ArchiveProductController.php";
require_once "Controllers/SingleProductController.php";
require_once "Controllers/CartController.php";
require_once "Controllers/CheckoutController.php";
require_once "Controllers/UserController.php";


require "Views/layouts/header.php";

// router cơ bản
if (isset($_GET['pages']) && !empty($_GET['pages'])) {
    switch ($_GET['pages']) {
        case "home":
            $controller = new HomeController();
            $controller->renderGiaoDien();
            break;
        case "danh-sach-san-pham":
            $controller = new ArchiveProductController();
            $controller->renderGiaoDienDanhMucSanPham();
            break;

        case "chi-tiet-san-pham":
            $controller = new SingleProductController();
            $controller->renderGiaoDienChiTietSanPham();
            break;

        case "gio-hang":
            $controller = new CartController();
            $controller->renderGiaoDienGioHang();
            break;
        case "thanh-toan":
            $controller = new CheckoutController();
            $controller->renderGiaoDienThanhToan();
            break;
        case "dang-nhap":
            $controller = new UserController();
            $controller->renderGiaoDienDangNhap();
            break;
        default:
            echo "404";
            break;
    }
} else {
    $controller = new HomeController();
    $controller->renderGiaoDien();
}



require "Views/layouts/footer.php";
// include, include_once, require, require_once
