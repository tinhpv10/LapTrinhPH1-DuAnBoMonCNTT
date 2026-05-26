<?php
// controllers/HomeController.php

class HomeController
{
    public function index()
    {
        // Tại đây bạn có thể gọi Model để lấy sản phẩm mới, sản phẩm bán chạy...
        $pageTitle = "Trang Chủ - Thời Trang Nữ";

        // Gọi file giao diện Home (File Home này hiển thị nội dung trang chủ)
        // Lưu ý: File views/home.php trống tên trong ảnh, nhưng controller của bạn sẽ gọi nó khi chạy.
        if (file_exists('views/home.php')) {
            include 'views/home.php';
        } else {
            echo "Chào mừng bạn đến với Website Thời Trang Nữ!";
        }
    }
}