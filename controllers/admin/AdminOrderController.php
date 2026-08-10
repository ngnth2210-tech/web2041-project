<?php

class AdminOrderController
{
    private $modelOrder;
    private $modelProduct;

    public function __construct() {
        $this->modelOrder   = new Order();
        $this->modelProduct = new Product();
    }

    public function index() {
        $view  = 'order/index';
        $title = 'Quản lý đơn hàng';
        $data  = $this->modelOrder->getAll();
        require_once PATH_VIEW_MAIN_ADMIN;
    }

    public function show() {
        $id = $_GET['id'] ?? null;
        if (!$id) { header('Location: ?mode=admin&action=list-order'); exit; }

        $order      = $this->modelOrder->find($id);
        $orderItems = $this->modelOrder->getOrderItems($id);

        // Tính các trạng thái được phép chuyển tới
        $allowedStatuses = Order::allowedNextStatuses($order['status']);

        $view  = 'order/show';
        $title = 'Chi tiết đơn hàng #' . $id;
        require_once PATH_VIEW_MAIN_ADMIN;
    }

    public function updateStatus() {
        $id     = $_GET['id'] ?? null;
        $status = $_POST['status'] ?? null;

        if (!$id || !$status) {
            header('Location: ?mode=admin&action=list-order');
            exit;
        }

        $order = $this->modelOrder->find($id);
        if (!$order) {
            header('Location: ?mode=admin&action=list-order');
            exit;
        }

        $oldStatus = $order['status'];

        // Kiểm tra transition hợp lệ
        if (!Order::canTransition($oldStatus, $status)) {
            $_SESSION['error'] = "Không thể chuyển từ \"{$oldStatus}\" sang \"{$status}\".";
            header('Location: ?mode=admin&action=show-order&id=' . $id);
            exit;
        }

        // Nếu hủy đơn → hoàn trả kho
        if ($status === 'cancelled') {
            $items = $this->modelOrder->getOrderItems($id);
            foreach ($items as $item) {
                $this->modelProduct->increaseQuantity($item['product_id'], $item['quantity']);
            }
        }

        $this->modelOrder->updateStatus($id, $status);
        header('Location: ?mode=admin&action=show-order&id=' . $id);
        exit;
    }

    public function delete() {
        $id = $_GET['id'] ?? null;
        if (!$id) { header('Location: ?mode=admin&action=list-order'); exit; }

        $order = $this->modelOrder->find($id);

        if ($order && $order['status'] === 'completed') {
            $_SESSION['error'] = 'Không thể xóa đơn hàng đã hoàn thành!';
            header('Location: ?mode=admin&action=list-order');
            exit;
        }

        // Hoàn trả kho nếu đơn chưa bị hủy
        if ($order && $order['status'] !== 'cancelled') {
            $items = $this->modelOrder->getOrderItems($id);
            foreach ($items as $item) {
                $this->modelProduct->increaseQuantity($item['product_id'], $item['quantity']);
            }
        }

        $this->modelOrder->delete($id);
        header('Location: ?mode=admin&action=list-order');
        exit;
    }
}
