<?php
// controllers/ProductController.php

class ProductController
{
    public function listProducts()
    {
        $pageTitle = "Danh Sách Sản Phẩm";


        $products = [
            ['id' => 1, 'name' => 'Váy Hoa Nhí Dáng Dài', 'price' => 350000],
            ['id' => 2, 'name' => 'Áo Sơ Mi Kiểu Hàn Quốc', 'price' => 220000]
        ];


        include 'views/products.php';
    }

    public function detail()
    {
        $pageTitle = "Chi Tiết Sản Phẩm";
        $productId = isset($_GET['id']) ? $_GET['id'] : 0;


        $product = [
            'id' => $productId,
            'name' => 'Váy Cưới Trắng Công Chúa',
            'price' => 1500000,
            'desc' => 'Chất liệu ren cao cấp, tôn dáng, phù hợp cho các buổi tiệc sang trọng.'
        ];


        include 'views/product-detail.php';
    }
}