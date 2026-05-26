<?php
require_once __DIR__ . '/../Controllers/CategoryController.php';

$controller = new CategoryController();

$action = $_GET['action'] ?? 'list';
$message = '';
$messageType = '';

// Xử lý POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($action === 'add') {
        $result = $controller->addCategory($_POST);
        $message = $result ? 'Thêm danh mục thành công!' : 'Thêm danh mục thất bại!';
        $messageType = $result ? 'success' : 'danger';
        $action = 'list';
    } elseif ($action === 'edit') {
        $result = $controller->updateCategory($_GET['id'], $_POST);
        $message = $result ? 'Cập nhật thành công!' : 'Cập nhật thất bại!';
        $messageType = $result ? 'success' : 'danger';
        $action = 'list';
    }
}

// Xử lý DELETE
if ($action === 'delete' && isset($_GET['id'])) {
    $result = $controller->deleteCategory($_GET['id']);
    $message = $result ? 'Xóa danh mục thành công!' : 'Xóa thất bại!';
    $messageType = $result ? 'success' : 'danger';
    $action = 'list';
}

$categories = $controller->getAllCategories();
$editCategory = null;
if ($action === 'edit' && isset($_GET['id'])) {
    $editCategory = $controller->getCategoryById($_GET['id']);
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý danh mục</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.css">
    <link rel="stylesheet" href="../assets/css/font-awesome.min.css">
    <style>
        body {
            background: #f4f6f9;
        }

        .sidebar {
            min-height: 100vh;
            background: #343a40;
            padding: 0;
        }

        .sidebar a {
            color: #adb5bd;
            display: block;
            padding: 12px 20px;
            text-decoration: none;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: #495057;
            color: #fff;
        }

        .sidebar .brand {
            background: #212529;
            padding: 18px 20px;
            font-size: 20px;
            font-weight: bold;
            color: #fff;
        }

        .main-content {
            padding: 30px;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .table th {
            background: #f8f9fa;
        }

        .badge-pill {
            padding: 6px 12px;
            font-size: 13px;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">

            <!-- Sidebar -->
            <div class="col-md-2 sidebar p-0">
                <div class="brand">⚙ Admin</div>
                <a href="dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a>
                <a href="products.php"><i class="fa fa-tag"></i> Sản phẩm</a>
                <a href="categories.php" class="active"><i class="fa fa-list"></i> Danh mục</a>
                <a href="orders.php"><i class="fa fa-shopping-cart"></i> Đơn hàng</a>
                <a href="users.php"><i class="fa fa-users"></i> Người dùng</a>
                <a href="../index.php"><i class="fa fa-home"></i> Về trang chủ</a>
            </div>

            <!-- Main -->
            <div class="col-md-10 main-content">
                <h4 class="mb-4"><i class="fa fa-list"></i> Quản lý danh mục</h4>

                <!-- Thông báo -->
                <?php if ($message): ?>
                    <div class="alert alert-<?= $messageType ?> alert-dismissible fade show">
                        <i class="fa fa-<?= $messageType === 'success' ? 'check-circle' : 'times-circle' ?>"></i>
                        <?= $message ?>
                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                    </div>
                <?php endif; ?>

                <div class="row">

                    <!-- Form Thêm / Sửa -->
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <i class="fa fa-<?= $action === 'edit' ? 'edit' : 'plus-circle' ?>"></i>
                                    <?= $action === 'edit' ? 'Chỉnh sửa danh mục' : 'Thêm danh mục mới' ?>
                                </h5>
                                <form method="POST"
                                    action="categories.php?action=<?= $action ?><?= $action === 'edit' ? '&id=' . $_GET['id'] : '' ?>">

                                    <div class="form-group">
                                        <label>Tên danh mục <span class="text-danger">*</span></label>
                                        <input type="text" name="name" class="form-control"
                                            placeholder="VD: Áo nam, Váy nữ..." required
                                            value="<?= htmlspecialchars($editCategory['name'] ?? '') ?>">
                                    </div>

                                    <div class="form-group">
                                        <label>Mô tả</label>
                                        <textarea name="description" class="form-control" rows="3"
                                            placeholder="Mô tả ngắn về danh mục..."><?= htmlspecialchars($editCategory['description'] ?? '') ?></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label>Trạng thái</label>
                                        <select name="status" class="form-control">
                                            <option value="1" <?= ($editCategory['status'] ?? 1) == 1 ? 'selected' : '' ?>>
                                                Hiển thị
                                            </option>
                                            <option value="0" <?= ($editCategory['status'] ?? 1) == 0 ? 'selected' : '' ?>>
                                                Ẩn
                                            </option>
                                        </select>
                                    </div>

                                    <div class="d-flex gap-2">
                                        <button type="submit"
                                            class="btn btn-<?= $action === 'edit' ? 'warning' : 'success' ?> btn-block">
                                            <i class="fa fa-save"></i>
                                            <?= $action === 'edit' ? ' Cập nhật' : ' Thêm danh mục' ?>
                                        </button>
                                        <?php if ($action === 'edit'): ?>
                                            <a href="categories.php" class="btn btn-secondary btn-block mt-2">
                                                <i class="fa fa-times"></i> Hủy
                                            </a>
                                        <?php endif; ?>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Danh sách danh mục -->
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="card-title mb-0">
                                        Danh sách danh mục
                                        <span
                                            class="badge badge-primary badge-pill ml-2"><?= count($categories) ?></span>
                                    </h5>
                                    <!-- Tìm kiếm -->
                                    <input type="text" id="searchInput" class="form-control w-50"
                                        placeholder="🔍 Tìm kiếm danh mục...">
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-hover" id="categoriesTable">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Tên danh mục</th>
                                                <th>Mô tả</th>
                                                <th>Trạng thái</th>
                                                <th>Thao tác</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($categories)): ?>
                                                <?php foreach ($categories as $i => $cat): ?>
                                                    <tr>
                                                        <td><?= $i + 1 ?></td>
                                                        <td><strong><?= htmlspecialchars($cat['name']) ?></strong></td>
                                                        <td>
                                                            <span class="text-muted">
                                                                <?= htmlspecialchars(mb_strimwidth($cat['description'] ?? '', 0, 40, '...')) ?>
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <?php if ($cat['status'] == 1): ?>
                                                                <span class="badge badge-success badge-pill">
                                                                    <i class="fa fa-check"></i> Hiển thị
                                                                </span>
                                                            <?php else: ?>
                                                                <span class="badge badge-secondary badge-pill">
                                                                    <i class="fa fa-eye-slash"></i> Ẩn
                                                                </span>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td>
                                                            <a href="categories.php?action=edit&id=<?= $cat['id'] ?>"
                                                                class="btn btn-warning btn-sm">
                                                                <i class="fa fa-edit"></i> Sửa
                                                            </a>

                                                            <a href="categories.php?action=delete&id=<?= $cat['id'] ?>"
                                                                class="btn btn-danger btn-sm"
                                                                onclick="return confirm('Xóa danh mục <?= htmlspecialchars($cat['name'], ENT_QUOTES) ?>?\nSản phẩm thuộc danh mục này sẽ không bị xóa.')">
                                                                <i class="fa fa-trash"></i> Xóa
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="5" class="text-center text-muted py-5">
                                                        <i class="fa fa-folder-open fa-3x mb-2 d-block"></i>
                                                        Chưa có danh mục nào
                                                    </td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script src="../assets/js/jquery-3.4.1.min.js"></script>
    <script src="../assets/js/bootstrap.js"></script>
    <script>
        // Tìm kiếm realtime
        document.getElementById('searchInput').addEventListener('keyup', function () {
            const keyword = this.value.toLowerCase();
            document.querySelectorAll('#categoriesTable tbody tr').forEach(row => {
                const name = row.cells[1]?.textContent.toLowerCase() || '';
                row.style.display = name.includes(keyword) ? '' : 'none';
            });
        });
    </script>
</body>

</html>