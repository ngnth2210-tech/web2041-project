<?php

class HomeController
{
    private $productModel;
    private $categoryModel;

    public function __construct() {
        $this->productModel = new Product();
        $this->categoryModel = new Category();
    }
   
    
    public function index() 
    {
        $view = 'home';
        
        $categories = $this->categoryModel->getAll(); 
        
        $category_id = $_GET['category_id'] ?? null;
        
        $top4Lastest = [];
        $top4View = [];
        $filteredProducts = [];

        if ($category_id) {
            $filteredProducts = $this->productModel->getProductsByCategoryID($category_id);
            $title = "Sản phẩm của danh mục";

        } else {
            $top4Lastest = $this->productModel->top4Lastest();
            $top4View = $this->productModel->top4View();
            $title = "";
        }

        require_once PATH_VIEW_MAIN_CLIENT;
    }
}