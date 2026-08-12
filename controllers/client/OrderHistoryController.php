<?php

class OrderHistoryController
{
    private $modelOrder;
    private $modelProduct;

    public function __construct() {
        $this->modelOrder   = new Order();
        $this->modelProduct = new Product();
    }

    // Danh sách đơn hàng của user
    public function index() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '?action=login');
            exit;
        }

        $orders = $this->modelOrder->getByUserId($_SESSION['user_id']);

        $view  = 'order/history';
        $title = 'Lịch sử đơn hàng';
        require_once PATH_VIEW_MAIN_CLIENT;
    }

    // Chi tiết 1 đơn hàng của user
    public function detail() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '?action=login');
            exit;
        }

        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: ' . BASE_URL . '?action=order-history');
            exit;
        }

        $order = $this->modelOrder->find($id);

        // Chỉ xem được đơn của chính mình
        if (!$order || $order['user_id'] != $_SESSION['user_id']) {
            header('Location: ' . BASE_URL . '?action=order-history');
            exit;
        }

        $orderItems = $this->modelOrder->getOrderItems($id);

        $view  = 'order/history-detail';
        $title = 'Đơn hàng #' . $id;
        require_once PATH_VIEW_MAIN_CLIENT;
    }

    // Khách hủy đơn — chỉ được hủy khi còn ở trạng thái pending
    public function cancel() {
    if (!isset($_SESSION['user_id'])) {
        header('Location: ' . BASE_URL . '?action=login');
        exit;
    }

    $id = $_GET['id'] ?? null;
    if (!$id) {
        header('Location: ' . BASE_URL . '?action=order-history');
        exit;
    }

    $order = $this->modelOrder->find($id);

    // Chỉ hủy đơn của chính mình
    if (!$order || $order['user_id'] != $_SESSION['user_id']) {
        header('Location: ' . BASE_URL . '?action=order-history');
        exit;
    }

    // Không cho hủy nếu đã thanh toán
    if (($order['payment_status'] ?? '') === 'paid') {
        $_SESSION['error'] = 'Đơn hàng đã thanh toán nên không thể hủy.';
        header('Location: ' . BASE_URL . '?action=order-detail&id=' . $id);
        exit;
    }

    // Chỉ cho hủy khi pending
    if ($order['status'] !== 'pending') {
        $_SESSION['error'] = 'Chỉ có thể hủy đơn hàng khi đang ở trạng thái <strong>Chờ xác nhận</strong>.';
        header('Location: ' . BASE_URL . '?action=order-detail&id=' . $id);
        exit;
    }

    // Hoàn kho
    $items = $this->modelOrder->getOrderItems($id);
    foreach ($items as $item) {
        $this->modelProduct->increaseQuantity($item['product_id'], $item['quantity']);
    }

    $this->modelOrder->updateStatus($id, 'cancelled');

    $_SESSION['success'] = 'Đơn hàng #' . $id . ' đã được hủy thành công.';
    header('Location: ' . BASE_URL . '?action=order-history');
    exit;
}
}
