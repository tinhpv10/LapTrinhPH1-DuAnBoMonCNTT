<?php
require_once "Models/Category.php";

class CategoryController {
    private $model;

    public function __construct() {
        $this->model = new Category();
    }

    public function getAllCategories() {
        return $this->model->getAll();
    }

    public function getCategoryById($id) {
        return $this->model->getById($id);
    }

    public function addCategory($data) {
        return $this->model->insert($data);
    }

    public function updateCategory($id, $data) {
        return $this->model->update($id, $data);
    }

    public function deleteCategory($id) {
        return $this->model->delete($id);
    }
}