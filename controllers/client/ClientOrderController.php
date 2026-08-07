<?php

class ClientOrderController
{
    private $modelOrder;
    private $modelProduct;

    public function __construct() {
        $this->modelOrder   = new Order();
        $this->modelProduct = new Product();
    }

    // Hiển thị form đặt hàng 1 sản phẩm
    public function create() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '?action=login');
            exit;
        }

        $id = $_GET['id'] ?? null;
        if (!$id) { header('Location: ' . BASE_URL); exit; }

        $product = $this->modelProduct->find($id);
        if (!$product) { header('Location: ' . BASE_URL); exit; }

        // Kiểm tra sản phẩm bị ẩn hoặc hết hàng ngay từ trang form
        if (($product['status'] ?? 1) == 0) {
            $_SESSION['error'] = 'Sản phẩm này hiện không còn bán.';
            header('Location: ' . BASE_URL);
            exit;
        }

        $view  = 'order/create';
        $title = 'Đặt hàng: ' . $product['name'];
        require_once PATH_VIEW_MAIN_CLIENT;
    }

    // Hiển thị form đặt hàng từ giỏ hàng
    public function createFromCart() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '?action=login');
            exit;
        }

        if (empty($_SESSION['cart'])) {
            header('Location: ' . BASE_URL . '?action=cart');
            exit;
        }

        // Kiểm tra tồn kho cho từng sản phẩm trong giỏ
        $outOfStock = [];
        foreach ($_SESSION['cart'] as $productId => $item) {
            $product = $this->modelProduct->find($productId);
            if (!$product || ($product['status'] ?? 1) == 0) {
                $outOfStock[] = ($item['name'] ?? "SP#$productId") . ' (không còn bán)';
            } elseif ($product['quantity'] < $item['quantity']) {
                $outOfStock[] = htmlspecialchars($item['name'])
                    . " (kho còn {$product['quantity']}, bạn chọn {$item['quantity']})";
            }
        }

        if (!empty($outOfStock)) {
            $_SESSION['error'] = 'Một số sản phẩm trong giỏ không đủ hàng: <br>• ' . implode('<br>• ', $outOfStock);
            header('Location: ' . BASE_URL . '?action=cart');
            exit;
        }

        $cart  = $_SESSION['cart'];
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        $view  = 'order/create-from-cart';
        $title = 'Đặt hàng';
        require_once PATH_VIEW_MAIN_CLIENT;
    }

    // Xử lý lưu đơn hàng (POST) — cả đơn lẻ lẫn từ giỏ
    public function store() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '?action=login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL);
            exit;
        }

        // ── Đặt từ giỏ hàng ──────────────────────────────────
        if (!empty($_SESSION['cart']) && !isset($_POST['product_id'])) {
            $this->storeFromCart();
            return;
        }

        // ── Đặt 1 sản phẩm ───────────────────────────────────
        $product_id = $_POST['product_id'] ?? null;
        $quantity   = intval($_POST['quantity'] ?? 1);

        if (!$product_id || $quantity < 1) {
            header('Location: ' . BASE_URL);
            exit;
        }

        $product = $this->modelProduct->find($product_id);
        if (!$product) {
            header('Location: ' . BASE_URL);
            exit;
        }

        // Kiểm tra sản phẩm có bị ẩn không
        if (($product['status'] ?? 1) == 0) {
            $error = 'Sản phẩm này hiện không còn bán.';
            $view  = 'order/create';
            $title = 'Đặt hàng';
            require_once PATH_VIEW_MAIN_CLIENT;
            exit;
        }

        // Kiểm tra & trừ tồn kho (atomic — dùng WHERE quantity >= qty trong SQL)
        $affected = $this->modelProduct->decreaseQuantity($product_id, $quantity);

        if ($affected === 0) {
            // Không đủ hàng
            $error = "Rất tiếc! Kho chỉ còn <strong>{$product['quantity']}</strong> sản phẩm,"
                   . " bạn đã đặt <strong>{$quantity}</strong>. Vui lòng giảm số lượng.";
            $view  = 'order/create';
            $title = 'Đặt hàng: ' . $product['name'];
            require_once PATH_VIEW_MAIN_CLIENT;
            exit;
        }

        $total_price = $product['price'] * $quantity;

        $order_id = $this->modelOrder->insert([
            'user_id'          => $_SESSION['user_id'],
            'customer_name'    => trim($_POST['customer_name']),
            'customer_phone'   => trim($_POST['customer_phone']),
            'customer_address' => trim($_POST['customer_address']),
            'note'             => trim($_POST['note'] ?? ''),
            'total_price'      => $total_price,
        ]);

        $this->modelOrder->insertItem([
            'order_id'   => $order_id,
            'product_id' => $product_id,
            'quantity'   => $quantity,
            'price'      => $product['price'],
        ]);

        header('Location: ' . BASE_URL . '?action=order-success&id=' . $order_id);
        exit;
    }

    // Xử lý đặt hàng từ giỏ (private helper)
    private function storeFromCart() {
        $cart = $_SESSION['cart'] ?? [];
        if (empty($cart)) {
            header('Location: ' . BASE_URL . '?action=cart');
            exit;
        }

        // Kiểm tra & trừ tồn kho cho từng sản phẩm — rollback nếu bất kỳ sản phẩm nào thất bại
        $deducted = []; // lưu lại để rollback
        $errors   = [];

        foreach ($cart as $productId => $item) {
            $product  = $this->modelProduct->find($productId);
            $qty      = $item['quantity'];

            if (!$product || ($product['status'] ?? 1) == 0) {
                $errors[] = htmlspecialchars($item['name']) . ' không còn bán.';
                continue;
            }

            $affected = $this->modelProduct->decreaseQuantity($productId, $qty);

            if ($affected === 0) {
                $errors[] = htmlspecialchars($item['name'])
                    . " — kho còn {$product['quantity']}, bạn đặt {$qty}.";
            } else {
                $deducted[$productId] = $qty; // ghi nhận đã trừ
            }
        }

        // Nếu có lỗi → hoàn lại tất cả đã trừ rồi báo lỗi
        if (!empty($errors)) {
            foreach ($deducted as $pid => $qty) {
                $this->modelProduct->increaseQuantity($pid, $qty);
            }
            $_SESSION['error'] = 'Không thể đặt hàng vì:<br>• ' . implode('<br>• ', $errors);
            header('Location: ' . BASE_URL . '?action=cart');
            exit;
        }

        // Tính tổng
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // Tạo đơn hàng
        $order_id = $this->modelOrder->insert([
            'user_id'          => $_SESSION['user_id'],
            'customer_name'    => trim($_POST['customer_name']),
            'customer_phone'   => trim($_POST['customer_phone']),
            'customer_address' => trim($_POST['customer_address']),
            'note'             => trim($_POST['note'] ?? ''),
            'total_price'      => $total,
        ]);

        // Lưu từng sản phẩm trong đơn
        foreach ($cart as $productId => $item) {
            $this->modelOrder->insertItem([
                'order_id'   => $order_id,
                'product_id' => $productId,
                'quantity'   => $item['quantity'],
                'price'      => $item['price'],
            ]);
        }

        // Xóa giỏ hàng
        unset($_SESSION['cart']);

        header('Location: ' . BASE_URL . '?action=order-success&id=' . $order_id);
        exit;
    }

    // Trang xác nhận thành công
    public function success() {
        $id = $_GET['id'] ?? null;
        if (!$id) { header('Location: ' . BASE_URL); exit; }

        $order      = $this->modelOrder->find($id);
        $items      = $this->modelOrder->getOrderItems($id);
        $orderItems = $items; // alias cho view cũ

        $view  = 'order/success';
        $title = 'Đặt hàng thành công!';
        require_once PATH_VIEW_MAIN_CLIENT;
    }
}
