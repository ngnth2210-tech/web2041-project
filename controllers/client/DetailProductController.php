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

        // Lấy danh mục
        $category = $this->categoryModel->find($product['category_id']);

        // Lấy bình luận của sản phẩm
        $comments = $this->commentModel->getByProductID($id);

        // Sản phẩm cùng danh mục, bỏ chính nó ra, lấy tối đa 4
        $related = [];

        foreach (
            $this->productModel->getProductsByCategoryID(
                $product['category_id']
            ) as $item
        ) {
            if ($item['id'] == $id) {
                continue;
            }

            $related[] = $item;

            if (count($related) == 4) {
                break;
            }
        }

        // Thông báo lỗi bình luận
        $commentError = $_SESSION['comment_error'] ?? null;
        unset($_SESSION['comment_error']);

        $view  = 'detail/index';
        $title = $product['name'];

        require_once PATH_VIEW_MAIN_CLIENT;
    }

    public function storeComment()
    {
        // Chỉ nhận POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect(BASE_URL);
            exit;
        }

        // Lấy ID sản phẩm
        $id = (int) ($_POST['product_id'] ?? 0);

        if (!$id) {
            redirect(BASE_URL);
            exit;
        }

        // URL quay lại sản phẩm
        $backUrl = BASE_URL . '?action=detail-product&id=' . $id;

        // Kiểm tra đăng nhập
        $userId = $_SESSION['user_id'] ?? null;

        if (!$userId) {
            $_SESSION['comment_error'] = 'Bạn cần đăng nhập để viết bình luận.';
            redirect($backUrl);
            exit;
        }

        // Lấy nội dung
        $content = trim($_POST['content'] ?? '');

        if ($content === '') {
            $_SESSION['comment_error'] = 'Vui lòng nhập nội dung bình luận.';
            redirect($backUrl);
            exit;
        }

        // Kiểm tra sản phẩm tồn tại
        $product = $this->productModel->find($id);

        if (!$product || ($product['status'] ?? 1) == 0) {
            $_SESSION['comment_error'] = 'Sản phẩm không tồn tại hoặc đã bị ẩn.';
            redirect(BASE_URL);
            exit;
        }

        // Thêm bình luận
        $result = $this->commentModel->insert(
            $id,
            (int) $userId,
            $content
        );

        if ($result) {
            $_SESSION['success_message'] = 'Đã gửi bình luận của bạn.';
        } else {
            $_SESSION['comment_error'] = 'Không thể gửi bình luận. Vui lòng thử lại.';
        }

        redirect($backUrl . '#binh-luan');
        exit;
    }
}