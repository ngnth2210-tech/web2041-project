<?php
class CategoryController
{
    public $modelCategory;

    public function __construct() {
        $this->modelCategory = new Category();
    }

    public function index() {
        $view = 'category/index';
        $title = 'Danh sách Danh mục';
        $data = $this->modelCategory->getAll();
        require_once PATH_VIEW_MAIN_ADMIN;
    }

    public function create() {
        $view = 'category/create';
        $title = 'Tạo mới danh mục';
        require_once PATH_VIEW_MAIN_ADMIN;
    }

    public function store(): void
    {
        try {
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            if (empty($name)) {
                throw new Exception("Tên danh mục không được để trống.");
            }
            $this->modelCategory->insert($name, $description);
        } catch(Exception $ex) {
            throw new Exception("Thao tác tạo mới lỗi: " . $ex->getMessage());
        }
        header('Location:' . BASE_URL_ADMIN . '&action=list-category');
        exit();
    }

    public function edit() {
        $id = $_GET['id'] ?? null;
        if(!$id) throw new Exception("Thiếu tham số id.");
        $category = $this->modelCategory->find($id);
        if(empty($category)) throw new Exception("Danh mục k tồn tại.");
        $view = 'category/edit';
        $title = 'Sửa danh mục: ' . $category['name'];
        $data = $category;
        require_once PATH_VIEW_MAIN_ADMIN;
    }

    public function update(): void
    {
        $id = $_GET['id'] ?? null;
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $id) {
            $name = $_POST['name'] ?? '';
            if (empty($name)) throw new Exception("Tên danh mục không được để trống.");
            $this->modelCategory->update($id, $name);
            header('Location: ' . BASE_URL_ADMIN . '&action=list-category');
            exit;
        }
        header('Location: ' . BASE_URL_ADMIN . '&action=list-category');
        exit;
    }

    // DISABLE thay vì DELETE
    public function toggleStatus(): void
    {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $cat = $this->modelCategory->find($id);
            if (!empty($cat)) {
                $this->modelCategory->toggleStatus($id);
            }
        }
        header('Location:' . BASE_URL_ADMIN . '&action=list-category');
        exit();
    }
}
