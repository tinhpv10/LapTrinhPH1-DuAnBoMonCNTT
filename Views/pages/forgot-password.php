<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Quên Mật Khẩu - Thời Trang Nữ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card p-4 shadow" style="width: 400px;">
            <h3 class="text-center text-danger mb-4">Quên Mật Khẩu</h3>
            <p class="text-muted text-center text-sm">Vui lòng nhập email đăng ký. Chúng tôi sẽ gửi mã khôi phục mật
                khẩu về email của bạn.</p>

            <form action="" method="POST">
                <div class="mb-3">
                    <label for="email" class="form-label">Email của bạn</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="example@gmail.com"
                        required>
                </div>
                <button type="submit" class="btn btn-danger w-100">Gửi Mã Xác Nhận</button>
            </form>

            <div class="text-center mt-3">
                <a href="index.php?action=login" class="text-decoration-none text-secondary">Quay lại Đăng nhập</a>
            </div>
        </div>
    </div>
</body>

</html>