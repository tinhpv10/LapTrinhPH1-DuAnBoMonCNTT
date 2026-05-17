<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title></title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; background-color: #f9f9f9; }
        .box { background: #fff; padding: 20px; border: 1px solid #ddd; margin-bottom: 20px; max-width: 600px; border-radius: 5px;}
        .form-group { margin-bottom: 15px; display: flex; }
        .form-group label { width: 120px; font-weight: bold; }
        .form-group input, .form-group textarea { flex: 1; padding: 6px; }
        .btn-submit { background-color: #28a745; color: white; border: none; padding: 8px 15px; cursor: pointer; }
        .result { background-color: #e2e3e5; padding: 15px; margin-top: 10px; border-radius: 4px; }
    </style>
</head>
<body>
<center>
    <div class="box">
        <h2>Yêu cầu 1:</h2>
        <form action="" method="POST">
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" required>
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" rows="3"></textarea>
            </div>
            <div class="form-group">
                <label>Price</label>
                <input type="text" name="price" required>
            </div>
            <div class="form-group">
                <label></label>
                <button type="submit" name="btn_product" class="btn-submit">Save</button>
            </div>
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['btn_product'])) {
            // 1. Nhận dữ liệu
            $name = $_POST['name'];
            $desc = $_POST['description'];
            $price = $_POST['price'];

            // 2. Lưu vào mảng
            $product_array = [
                "Tên sản phẩm" => $name,
                "Mô tả" => $desc,
                "Giá" => $price
            ];

            // 3. In ra màn hình 
            echo "<div class='result'>";
            echo "<h3>Dữ liệu mảng sản phẩm vừa nhập:</h3>";
            echo "<pre>";
            print_r($product_array);
            echo "</pre>";
            echo "</div>";
        }
        ?>
    </div>

    <div class="box">
        <h2>Yêu cầu 2:</h2>
        <form action="" method="POST">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <div class="form-group">
                <label></label>
                <button type="submit" name="btn_login" class="btn-submit">Đăng nhập</button>
            </div>
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['btn_login'])) {
            $user = $_POST['username'];
            $pass = $_POST['password'];

            echo "<div class='result'>";
            echo "<h3>Kết quả đăng nhập:</h3>";
            echo "Tài khoản: " . $user . "<br>";
            echo "Mật khẩu: " . $pass;
            echo "</div>";
        }
        ?>
    </div>
    </center>

</body>
</html>