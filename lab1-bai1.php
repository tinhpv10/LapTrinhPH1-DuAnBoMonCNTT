<?php

$products = [
    [
        "id" => 1,
        "name" => "Hồ Điệp Và Kình Ngư",
        "price" => 104000,
        "image" => "https://cdn1.fahasa.com/media/catalog/product/b/i/bia-2d_ho-diep-va-kinh-ngu_17307.jpg"
    ],
    [
        "id" => 2,
        "name" => "Sứ Mệnh Hail Mary - Project Hail Mary",
        "price" => 136000,
        "image" => "https://cdn1.fahasa.com/media/catalog/product/b/_/b_a-1_7_12.jpg"
    ],
    [
        "id" => 3,
        "name" => "Người Đàn Ông Mang Tên OVE (Tái Bản)",
        "price" => 115200,
        "image" => "https://cdn1.fahasa.com/media/catalog/product/8/9/8934974182375.jpg"
    ],
];

foreach($products as $pro){
    echo $pro['name']."<hr>";
    echo number_format($pro['price'])."<hr>";
    echo "<img src='".$pro['image']."' >";
}