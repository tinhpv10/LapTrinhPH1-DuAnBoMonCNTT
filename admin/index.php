<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
// đường dẫn dùng $_GET
// domain.com?name=Tính&age=18&address=Cần%20Thơ
// $_GET['name'] giá trị sẽ là Tính
// $_GET['age'] giá trị sẽ là 18
// $_GET['address'] giá trị sẽ là Cần Thơ
// echo $_GET['address'];
require_once "admin/Controllers/HomeController.php";
require_once "admin/Controllers/ArchiveProductController.php";


require "Views/layouts/header.php";

// router cơ bản
if (isset($_GET['pages']) && !empty($_GET['pages'])) {
    switch ($_GET['pages']) {
        case "home":
            $controller = new HomeController();
            $controller->renderGiaoDien();
            break;
        case "chi-tiet-san-pham":
            require "Views/pages/chi-tiet-san-pham.php";
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
