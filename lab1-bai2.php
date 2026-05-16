<?php

session_start();

if (!isset($_SESSION['products'])) {

    $_SESSION['products'] = [

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
        ]

    ];

}

if (
    !empty($_POST) &&
    $_SERVER['REQUEST_METHOD'] == "POST"
) {

    $name  = $_POST['name'];
    $price = $_POST['price'];
    $image = $_POST['image'];

    $id = count($_SESSION['products']) + 1;

    $_SESSION['products'][] = [

        "id"    => $id,
        "name"  => $name,
        "price" => $price,
        "image" => $image

    ];

}

?>

<form action="" method="POST">

    <input
        type="text"
        name="name"
        placeholder="Nhập tên sách"
    >

    <br><br>

    <input
        type="number"
        name="price"
        placeholder="Nhập giá"
    >

    <br><br>

    <input
        type="text"
        name="image"
        placeholder="Nhập link ảnh"
    >

    <br><br>

    <button type="submit">
        Gửi đi
    </button>

</form>

<hr>

<?php foreach ($_SESSION['products'] as $product): ?>

    <div
        style="
            border:1px solid #ccc;
            width:250px;
            padding:10px;
            margin-bottom:20px;
        "
    >

        <img
            src="<?= $product['image'] ?>"
            width="200"
        >

        <h3>
            <?= $product['name'] ?>
        </h3>

        <p>
            Giá:
            <?= number_format($product['price']) ?> đ
        </p>

    </div>

<?php endforeach; ?>