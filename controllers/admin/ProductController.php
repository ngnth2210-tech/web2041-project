<?php

class ProductController
{
    public $modelProduct;
    public $modelCat;

    public function __construct()
    {
        $this->modelProduct = new Product();
        $this->modelCat = new Category();
    }

    public function home()
    {
        $title = 'Đây là trang quản trị';
        require_once PATH_VIEW_MAIN_ADMIN;
    }

    public function index()
    {
        $view = 'product/index';
        $title = 'Danh sách Sản phẩm';
        $data = $this->modelProduct->getAll();
        require_once PATH_VIEW_MAIN_ADMIN;
    }

    public function create()
    {
        $view = 'product/create';
        $title = 'Tạo mới sản phẩm';
        $categories = $this->modelCat->getAll();
        require_once PATH_VIEW_MAIN_ADMIN;
    }

    private function validateProduct($data)
    {
        if (empty($data['name'])) {
            throw new Exception("Tên sản phẩm không được để trống");
        }
        if (!is_numeric($data['price']) || $data['price'] < 0 || floor($data['price']) != $data['price']) {
            throw new Exception("Giá phải là số nguyên không âm");
        }
        if (!is_numeric($data['quantity']) || $data['quantity'] < 0 || floor($data['quantity']) != $data['quantity']) {
            throw new Exception("Số lượng phải là số nguyên không âm");
        }
    }

    public function store()
    {
        try {
            $data = $_POST + $_FILES;
            if ($data["image"]["size"] > 0) {
                $data["image"] = upload_file('products', $data["image"]);
            } else {
                $data["image"] = null;
            }
            if (isset($_POST['weights']) && is_array($_POST['weights'])) {
                $data['weights'] = implode(',', array_filter($_POST['weights']));
            } else {
                $data['weights'] = $data['weights'] ?? null;
            }
            $this->validateProduct($data);
            $this->modelProduct->insert($data);
            header('Location:' . BASE_URL_ADMIN . '&action=list-product');
            exit();
        } catch (Exception $ex) {
            $_SESSION['errors'] = [$ex->getMessage()];
            $_SESSION['old']    = $_POST;
            header('Location:' . BASE_URL_ADMIN . '&action=create-product');
            exit();
        }
    }

    // DISABLE thay vì DELETE
    public function toggleStatus()
    {
        try {
            $id = $_GET['id'] ?? null;
            if (!$id) throw new Exception("Thiếu tham số id");
            $pro = $this->modelProduct->find($id);
            if (empty($pro)) throw new Exception("Sản phẩm không tồn tại");
            $this->modelProduct->toggleStatus($id);
        } catch (Exception $er) {
            $_SESSION['error'] = $er->getMessage();
        }
        header('Location:' . BASE_URL_ADMIN . '&action=list-product');
        exit();
    }

    public function show()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: ?mode=admin&action=list-product');
            exit;
        }
        $product = $this->modelProduct->find($id);
        $view = 'product/show';
        $title = 'Chi tiết sản phẩm';
        require_once PATH_VIEW_MAIN_ADMIN;
    }

    public function edit()
    {
        $id = $_GET['id'];
        $product = $this->modelProduct->find($id);
        $categories = $this->modelCat->getAll();
        $view = 'product/edit';
        $title = 'Thay đổi sản phẩm';
        require_once PATH_VIEW_MAIN_ADMIN;
    }

    public function update()
    {
        $id = $_GET['id'] ?? null;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            try {
                $data = [
                    'category_id' => $_POST['category_id'],
                    'name'        => $_POST['name'],
                    'description' => $_POST['description'],
                    'price'       => $_POST['price'],
                    'quantity'    => $_POST['quantity'],
                    'weights'     => $_POST['weights'],
                ];
                $this->validateProduct($data);

                // Xử lý ảnh
                $current = $this->modelProduct->find($id);
                if (!empty($_FILES['image']['size'])) {
                    $data['image'] = upload_file('products', $_FILES['image']);
                } else {
                    $data['image'] = $_POST['current_image'] ?? $current['image'];
                }

                $this->modelProduct->update($id, $data);
                header('Location: ?mode=admin&action=list-product');
                exit();
            } catch (Exception $e) {
                $_SESSION['errors'] = [$e->getMessage()];
                $_SESSION['old']    = $_POST;
                header('Location: ?mode=admin&action=edit-product&id=' . $id);
                exit();
            }
        }
    }
}
