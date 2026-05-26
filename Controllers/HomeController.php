<?php
require_once __DIR__ . "/../Models/Product.php";

class HomeController {

    public function renderGiaoDien() {

        $productModel = new Product();

        $products = $productModel->getAllProducts();

        require "Views/pages/home.php";
    }

}