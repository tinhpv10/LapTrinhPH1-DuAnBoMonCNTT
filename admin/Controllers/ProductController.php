<?php

class ProductController{
    public function renderGiaoDienSanPham(){
        require_once "Views/pages/sanpham/danhsach.php";
    }

    public function renderGiaoDienThemSanPham(){
        require_once "Views/pages/sanpham/them.php";
    }
}