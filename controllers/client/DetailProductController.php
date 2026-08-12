<?php

class DetailProductController
{
    private $productModel;
    private $categoryModel;
    private $commentModel;

    public function __construct()
    {
        $this->productModel  = new Product();
        $this->categoryModel = new Category();
        $this->commentModel  = new Comment();
    }

    public function show()
    {
        $id      = (int) ($_GET['id'] ?? 0);
        $product = $id ? $this->productModel->find($id) : null;

        // Không có sản phẩm, hoặc sản phẩm đang bị ẩn
        if (!$product || ($product['status'] ?? 1) == 0) {
            $view  = '404';
            $title = 'Không tìm thấy sản phẩm';
            require_once PATH_VIEW_MAIN_CLIENT;
            return;
        }

        // Tăng lượt xem
        $newViewCount = (int) ($product['view_count'] ?? 0) + 1;
        $this->productModel->updateViewCount($newViewCount, $id);
        $product['view_count'] = $newViewCount;

        $category = $this->categoryModel->find($product['category_id']);
        $comments = $this->commentModel->getByProductID($id);

        // Sản phẩm cùng danh mục, bỏ chính nó ra, lấy tối đa 4
        $related = [];
        foreach ($this->productModel->getProductsByCategoryID($product['category_id']) as $item) {
            if ($item['id'] == $id) {
                continue;
            }
            $related[] = $item;
            if (count($related) == 4) {
                break;
            }
        }

        $commentError = $_SESSION['comment_error'] ?? null;
        unset($_SESSION['comment_error']);

        $view  = 'detail/index';
        $title = $product['name'];

        require_once PATH_VIEW_MAIN_CLIENT;
    }

    public function storeComment()
    {
        $id = (int) ($_POST['product_id'] ?? 0);

        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !$id) {
            redirect(BASE_URL);
        }

        $backUrl = BASE_URL . '?action=detail-product&id=' . $id;

        // Chưa đăng nhập thì mời đăng nhập trước
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['comment_error'] = 'Bạn cần đăng nhập để viết bình luận.';
            redirect($backUrl);
        }

        $content = trim($_POST['content'] ?? '');

        if ($content === '') {
            $_SESSION['comment_error'] = 'Vui lòng nhập nội dung bình luận.';
            redirect($backUrl);
        }

        // Chỉ cho bình luận sản phẩm có thật và đang hiện
        $product = $this->productModel->find($id);
        if (!$product || ($product['status'] ?? 1) == 0) {
            redirect(BASE_URL);
        }

        $this->commentModel->insert($id, $_SESSION['user_id'], $content);

        $_SESSION['success_message'] = 'Đã gửi bình luận của bạn.';
        redirect($backUrl . '#binh-luan');
    }
}
