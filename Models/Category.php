<?php
require_once __DIR__ . '/../config/database.php';

class Category
{
    private $conn;
    private $table = 'categories';

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Lấy tất cả danh mục
    public function getAll()
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY id DESC";
        $result = $this->conn->query($sql);

        if (!$result) {
            return [];
        }

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Lấy danh mục theo ID
    public function getById($id)
    {
        $id = (int) $id;

        $sql = "SELECT * FROM {$this->table}
                WHERE id = {$id}
                LIMIT 1";

        $result = $this->conn->query($sql);

        if (!$result) {
            return null;
        }

        return $result->fetch_assoc();
    }

    // Thêm danh mục
    public function insert($data)
    {
        $name = $this->conn->real_escape_string(trim($data['name']));
        $description = $this->conn->real_escape_string(trim($data['description'] ?? ''));
        $status = isset($data['status']) ? (int) $data['status'] : 1;

        $sql = "INSERT INTO {$this->table}
                (name, description, status)
                VALUES
                ('$name', '$description', $status)";

        return $this->conn->query($sql);
    }

    // Cập nhật danh mục
    public function update($id, $data)
    {
        $id = (int) $id;

        $name = $this->conn->real_escape_string(trim($data['name']));
        $description = $this->conn->real_escape_string(trim($data['description'] ?? ''));
        $status = isset($data['status']) ? (int) $data['status'] : 1;

        $sql = "UPDATE {$this->table}
                SET
                    name = '$name',
                    description = '$description',
                    status = $status
                WHERE id = $id";

        return $this->conn->query($sql);
    }

    // Xóa danh mục
    public function delete($id)
    {
        $id = (int) $id;

        $sql = "DELETE FROM {$this->table}
                WHERE id = $id";

        return $this->conn->query($sql);
    }

    // Danh mục đang hiển thị
    public function getActive()
    {
        $sql = "SELECT *
                FROM {$this->table}
                WHERE status = 1
                ORDER BY name ASC";

        $result = $this->conn->query($sql);

        if (!$result) {
            return [];
        }

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Đếm sản phẩm
    public function countProducts($id)
    {
        $id = (int) $id;

        $sql = "SELECT COUNT(*) AS total
                FROM products
                WHERE category_id = $id";

        $result = $this->conn->query($sql);

        if (!$result) {
            return 0;
        }

        $row = $result->fetch_assoc();

        return (int) $row['total'];
    }
}