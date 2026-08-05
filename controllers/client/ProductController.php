<?php

class ProductController
{
    private $productModel;
    private $categoryModel;

    public function __construct()
    {
        $this->productModel  = new Product();
        $this->categoryModel = new Category();
    }

    public function index()
    {
        $category_id = $_GET['category_id'] ?? null;
        $keyword     = trim($_GET['keyword'] ?? '');

        $products   = $this->productModel->getActiveProducts($category_id, $keyword);
        $categories = $this->categoryModel->getAll();

        // Tên danh mục đang lọc, để hiện trên tiêu đề
        $currentCategory = null;
        if (!empty($category_id)) {
            $currentCategory = $this->categoryModel->find($category_id);
        }

        $view  = 'product/index';
        $title = 'Sản phẩm';

        require_once PATH_VIEW_MAIN_CLIENT;
    }

    /**
     * Route `show-product` trỏ vào đây, nhưng trang chi tiết do
     * DetailProductController đảm nhiệm. Chuyển hướng để tránh hai
     * đường dẫn cùng hiện một sản phẩm.
     */
    public function show()
    {
        $id = (int) ($_GET['id'] ?? 0);
        redirect(BASE_URL . '?action=detail-product&id=' . $id);
    }
}
