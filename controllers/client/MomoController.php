<?php

class MomoController
{
    private $modelOrder;
    private $modelProduct;

    public function __construct() {
        require_once PATH_ROOT . 'configs/MomoPayment.php';
        $this->modelOrder   = new Order();
        $this->modelProduct = new Product();
    }

    /**
     * Nhận POST từ form đặt hàng, lưu đơn trạng thái "pending_payment",
     * rồi redirect sang MoMo.
     */
    public function pay() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '?action=login'); exit;
        }
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL); exit;
        }

        // ── Xác định đây là đơn lẻ hay từ giỏ hàng ──────────
        $fromCart   = empty($_POST['product_id']) && !empty($_SESSION['cart']);
        $productId  = $_POST['product_id'] ?? null;
        $quantity   = intval($_POST['quantity'] ?? 1);

        // Validate & trừ kho
        if ($fromCart) {
            [$totalPrice, $cartSnapshot, $error] = $this->prepareCart();
        } else {
            [$totalPrice, $cartSnapshot, $error] = $this->prepareSingle($productId, $quantity);
        }

        if ($error) {
            $_SESSION['error'] = $error;
            $back = $fromCart
                ? BASE_URL . '?action=cart'
                : BASE_URL . '?action=order-create&id=' . $productId;
            header('Location: ' . $back); exit;
        }

        // Lưu đơn hàng với status = pending (chờ MoMo xác nhận)
        $orderId = $this->modelOrder->insert([
            'user_id'          => $_SESSION['user_id'],
            'customer_name'    => trim($_POST['customer_name']),
            'customer_phone'   => trim($_POST['customer_phone']),
            'customer_address' => trim($_POST['customer_address']),
            'note'             => trim($_POST['note'] ?? ''),
            'total_price'      => $totalPrice,
        ]);
         // Cập nhật payment_method & status tạm
        $this->modelOrder->setPaymentPending($orderId, 'momo');

        // Lưu items
        foreach ($cartSnapshot as $item) {
            $this->modelOrder->insertItem([
                'order_id'   => $orderId,
                'product_id' => $item['product_id'],
                'quantity'   => $item['quantity'],
                'price'      => $item['price'],
            ]);
        }

        // Xóa giỏ nếu đặt từ giỏ
        if ($fromCart) unset($_SESSION['cart']);

        // Redirect sang MoMo
        try {
            $payUrl = MomoPayment::createPayment($orderId, $totalPrice);
            header('Location: ' . $payUrl); exit;
        } catch (Exception $e) {
            // MoMo lỗi → hủy đơn, hoàn kho
            $this->cancelOrder($orderId);
            $_SESSION['error'] = 'Không thể kết nối MoMo: ' . $e->getMessage() . ' — Vui lòng thử lại.';
            header('Location: ' . BASE_URL . '?action=order-history'); exit;
        }
    }

    /**
     * MoMo redirect về sau khi thanh toán (GET)
     */
    public function returnUrl() {
        $params = $_GET;
        $orderId = MomoPayment::extractOrderId($params['orderId'] ?? '');

        if (!$orderId) {
            header('Location: ' . BASE_URL . '?action=order-history'); exit;
        }

        $order = $this->modelOrder->find($orderId);
        if (!$order) {
            header('Location: ' . BASE_URL . '?action=order-history'); exit;
        }

        $resultCode = intval($params['resultCode'] ?? -1);

        if ($resultCode === 0) {
            // Thanh toán thành công
            // cập nhật thanh toán
    $this->modelOrder->setPaymentSuccess($orderId, $params['transId'] ?? '');

    // cập nhật trạng thái đơn hàng
    $this->modelOrder->updateStatus($orderId, 'confirmed');

    header('Location: ' . BASE_URL . '?action=order-success&id=' . $orderId);
    exit;
        } else {
            // Thanh toán thất bại / bị hủy → hoàn kho
            $this->cancelOrder($orderId);
            $_SESSION['error'] = 'Thanh toán MoMo không thành công hoặc bị hủy. Đơn hàng đã được hủy.';
            header('Location: ' . BASE_URL . '?action=order-history'); exit;
        }
    }

    /**
     * MoMo IPN (server-to-server notify) — POST
     */
    public function notify() {
        $body   = file_get_contents('php://input');
        $params = json_decode($body, true) ?? [];

        if (!MomoPayment::verifySignature($params)) {
            http_response_code(400);
            echo json_encode(['message' => 'Invalid signature']);
            exit;
        }

        $orderId    = MomoPayment::extractOrderId($params['orderId'] ?? '');
        $resultCode = intval($params['resultCode'] ?? -1);

        if ($orderId) {
            if ($resultCode === 0) {
                // cập nhật thanh toán
    $this->modelOrder->setPaymentSuccess($orderId, $params['transId'] ?? '');

    // cập nhật trạng thái đơn hàng
    $this->modelOrder->updateStatus($orderId, 'confirmed');
            } else {
                $this->cancelOrder($orderId);
            }
        }

        http_response_code(204);
        exit;
    }

    // ── Helpers ──────────────────────────────────────────────────

    private function prepareSingle($productId, $quantity): array {
        if (!$productId || $quantity < 1) return [0, [], 'Thông tin sản phẩm không hợp lệ.'];

        $product = $this->modelProduct->find($productId);
        if (!$product || ($product['status'] ?? 1) == 0) return [0, [], 'Sản phẩm không tồn tại.'];

        $affected = $this->modelProduct->decreaseQuantity($productId, $quantity);
        if ($affected === 0) return [0, [], "Kho chỉ còn <strong>{$product['quantity']}</strong> sản phẩm."];

        $total = $product['price'] * $quantity;
        $snapshot = [['product_id' => $productId, 'quantity' => $quantity, 'price' => $product['price']]];
        return [$total, $snapshot, null];
    }

    private function prepareCart(): array {
        $cart     = $_SESSION['cart'] ?? [];
        $deducted = [];
        $errors   = [];
        $snapshot = [];
        $total    = 0;

        foreach ($cart as $productId => $item) {
            $product = $this->modelProduct->find($productId);
            $qty     = $item['quantity'];

            if (!$product || ($product['status'] ?? 1) == 0) {
                $errors[] = htmlspecialchars($item['name']) . ' không còn bán.';
                continue;
            }
            $affected = $this->modelProduct->decreaseQuantity($productId, $qty);
            if ($affected === 0) {
                $errors[] = htmlspecialchars($item['name']) . " — kho còn {$product['quantity']}, bạn đặt {$qty}.";
            } else {
                $deducted[$productId] = $qty;
                $snapshot[] = ['product_id' => $productId, 'quantity' => $qty, 'price' => $item['price']];
                $total += $item['price'] * $qty;
            }
        }

        if (!empty($errors)) {
            foreach ($deducted as $pid => $qty) $this->modelProduct->increaseQuantity($pid, $qty);
            return [0, [], 'Không đủ hàng:<br>• ' . implode('<br>• ', $errors)];
        }

        return [$total, $snapshot, null];
    }

    private function cancelOrder(int $orderId): void {
        $items = $this->modelOrder->getOrderItems($orderId);
        foreach ($items as $item) {
            $this->modelProduct->increaseQuantity($item['product_id'], $item['quantity']);
        }
        $this->modelOrder->updateStatus($orderId, 'cancelled');
    }
}
