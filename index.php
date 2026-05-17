<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    

    <h1 class="text1">Product List</h1>

    <div class="container">
        <?php
        include 'lab1-bai1.php';
        ?>
        <div class="product-list">
            <?php foreach ($product as $item) : ?>
                <div class="product-item">
                    <h2><?php echo $item['name']; ?></h2>
                    <p>Price: $<?php echo $item['price']; ?></p>
                    <img src="<?php echo $item['img']; ?>" alt="<?php echo $item['name']; ?>" style="width:200px;">
                    <p><?php echo $item['desc']; ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <br>



</body>

</html>
<?php
include_once "bai2_lab1/login.php";