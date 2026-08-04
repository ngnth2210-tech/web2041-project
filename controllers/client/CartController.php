<?php

class CartController
{
    // GET ?action=cart
    // Hiển thị trang giỏ hàng
   public function index()
{
    $cart  = $_SESSION['cart'] ?? [];
    $total = $this->calcTotal($cart);

    $title = 'Giỏ hàng'; 
    $view  = 'cart/index'; 
    require_once PATH_VIEW_CLIENT . 'main.php'; 
}

    public function add()
    {
        $productId = (int)($_POST['product_id'] ?? 0);
        $quantity  = max(1, (int)($_POST['quantity'] ?? 1));

        if ($productId <= 0) {
            $_SESSION['error'] = 'Sản phẩm không hợp lệ.';
            header('Location: ' . BASE_URL . '?action=cart');
            exit;
        }

        $productModel = new Product();
        $product      = $productModel->find($productId);

        if (!$product) {
            $_SESSION['error'] = 'Sản phẩm không tồn tại.';
            header('Location: ' . BASE_URL . '?action=cart');
            exit;
        }

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        if (isset($_SESSION['cart'][$productId])) {
            // Sản phẩm đã có trong giỏ → cộng thêm số lượng
            $_SESSION['cart'][$productId]['quantity'] += $quantity;
        } else {
            // Sản phẩm mới → thêm vào giỏ
            $_SESSION['cart'][$productId] = [
                'id'       => $product['id'],
                'name'     => $product['name'],
                'price'    => $product['price'],
                'image'    => $product['image'] ?? '',
                'quantity' => $quantity,
            ];
        }

        $_SESSION['success'] = 'Đã thêm "' . $product['name'] . '" vào giỏ hàng!';
        header('Location: ' . BASE_URL . '?action=cart');
        exit;
    }

    // POST ?action=cart-update
    // Cập nhật số lượng sản phẩm trong giỏ
    public function update()
    {
        $productId = (int)($_POST['product_id'] ?? 0);
        $quantity  = (int)($_POST['quantity'] ?? 1);

        if (isset($_SESSION['cart'][$productId])) {
            if ($quantity <= 0) {
                unset($_SESSION['cart'][$productId]);
            } else {
                $_SESSION['cart'][$productId]['quantity'] = $quantity;
            }
        }

        header('Location: ' . BASE_URL . '?action=cart');
        exit;
    }

    // GET ?action=cart-remove&id=X
    // Xoá 1 sản phẩm khỏi giỏ
    public function remove()
    {
        $productId = (int)($_GET['id'] ?? 0);

        if (isset($_SESSION['cart'][$productId])) {
            $name = $_SESSION['cart'][$productId]['name'];
            unset($_SESSION['cart'][$productId]);
            $_SESSION['success'] = 'Đã xoá "' . $name . '" khỏi giỏ hàng.';
        }

        header('Location: ' . BASE_URL . '?action=cart');
        exit;
    }

   
    public function clear()
    {
        $_SESSION['cart']   = [];
        $_SESSION['success'] = 'Đã xoá toàn bộ giỏ hàng.';
        header('Location: ' . BASE_URL . '?action=cart');
        exit;
    }

    // ─── Helper tính tổng tiền ───────────────────────────────────────────
    private function calcTotal(array $cart): float
    {
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }
}
