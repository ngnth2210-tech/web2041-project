<?php
class Order extends BaseModel {

    /** Các trạng thái đơn hàng hợp lệ, khớp với ENUM trong CSDL */
    public const TRANG_THAI = ['pending', 'confirmed', 'shipping', 'completed', 'cancelled'];

    /** Các trạng thái thanh toán hợp lệ */
    public const TRANG_THAI_TT = ['unpaid', 'pending', 'paid', 'failed'];

    /**
     * Tạo đơn hàng kèm chi tiết và trừ kho, gói trong một transaction.
     *
     * Ba việc này phải thành công cùng nhau: ghi đơn, ghi chi tiết, trừ kho.
     * Nếu một sản phẩm không đủ hàng thì huỷ toàn bộ, không để lại đơn dở dang.
     *
     * Lưu ý: mỗi model trong dự án tự mở một kết nối PDO riêng (xem BaseModel),
     * nên phần trừ kho phải viết ngay tại đây thay vì gọi Product->decreaseQuantity(),
     * nếu không nó chạy trên kết nối khác và nằm ngoài transaction.
     *
     * @param array $data  Thông tin người nhận: user_id, customer_name, customer_phone,
     *                     customer_address, note, payment_method
     * @param array $items Các dòng hàng, mỗi dòng cần: id, name, price, quantity
     *                     (đúng cấu trúc $_SESSION['cart'])
     * @return int         ID đơn vừa tạo
     * @throws Exception   Khi giỏ trống hoặc có sản phẩm không đủ hàng
     */
    public function createWithItems(array $data, array $items) {
        if (empty($items)) {
            throw new Exception('Giỏ hàng đang trống, không thể đặt hàng.');
        }

        $this->pdo->beginTransaction();

        try {
            // Tổng tiền tính lại từ giỏ, không tin con số gửi lên từ form
            $total = 0;
            foreach ($items as $item) {
                $total += $item['price'] * $item['quantity'];
            }

            $sql = "INSERT INTO `orders`
                (`user_id`, `customer_name`, `customer_phone`, `customer_address`,
                 `note`, `total_price`, `payment_method`)
                VALUES (:user_id, :customer_name, :customer_phone, :customer_address,
                        :note, :total_price, :payment_method)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                'user_id'          => $data['user_id'] ?? null,
                'customer_name'    => $data['customer_name'],
                'customer_phone'   => $data['customer_phone'],
                'customer_address' => $data['customer_address'],
                'note'             => $data['note'] ?? null,
                'total_price'      => $total,
                'payment_method'   => $data['payment_method'] ?? 'cod',
            ]);

            $orderId = (int) $this->pdo->lastInsertId();

            $stmtItem = $this->pdo->prepare(
                "INSERT INTO `order_items` (`order_id`, `product_id`, `quantity`, `price`)
                 VALUES (:order_id, :product_id, :quantity, :price)"
            );

            // WHERE quantity >= :qty2 để không bao giờ trừ xuống âm
            $stmtStock = $this->pdo->prepare(
                "UPDATE products SET quantity = quantity - :qty
                 WHERE id = :id AND quantity >= :qty2"
            );

            foreach ($items as $item) {
                $stmtItem->execute([
                    'order_id'   => $orderId,
                    'product_id' => $item['id'],
                    'quantity'   => $item['quantity'],
                    'price'      => $item['price'],
                ]);

                $stmtStock->execute([
                    'qty'  => $item['quantity'],
                    'id'   => $item['id'],
                    'qty2' => $item['quantity'],
                ]);

                if ($stmtStock->rowCount() === 0) {
                    throw new Exception('Sản phẩm "' . $item['name'] . '" không đủ hàng trong kho.');
                }
            }

            $this->pdo->commit();
            return $orderId;

        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }

    public function find($id) {
        $sql = 'SELECT * FROM `orders` WHERE id = :id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    /**
     * Lịch sử đơn của một người dùng, mới nhất lên đầu.
     */
    public function getByUserID($user_id) {
        $sql = 'SELECT * FROM `orders` WHERE user_id = :user_id ORDER BY id DESC';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['user_id' => $user_id]);
        return $stmt->fetchAll();
    }

    /**
     * Toàn bộ đơn cho khu quản trị, lọc theo trạng thái nếu cần.
     */
    public function getAll($status = null) {
        $sql = 'SELECT ord.*, usr.username
            FROM `orders` as ord
            LEFT JOIN users as usr ON ord.user_id = usr.id';
        $params = [];

        if (!empty($status)) {
            $sql .= ' WHERE ord.status = :status';
            $params['status'] = $status;
        }

        $sql .= ' ORDER BY ord.id DESC';

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function updateStatus($id, $status) {
        if (!in_array($status, self::TRANG_THAI, true)) {
            throw new Exception('Trạng thái đơn hàng không hợp lệ: ' . $status);
        }

        $sql = 'UPDATE `orders` SET status = :status WHERE id = :id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['status' => $status, 'id' => $id]);
    }

    /**
     * Cập nhật kết quả thanh toán, dùng cho luồng MoMo.
     */
    public function updatePayment($id, $payment_status, $momo_trans_id = null) {
        if (!in_array($payment_status, self::TRANG_THAI_TT, true)) {
            throw new Exception('Trạng thái thanh toán không hợp lệ: ' . $payment_status);
        }

        $sql = 'UPDATE `orders` SET payment_status = :payment_status, momo_trans_id = :momo_trans_id
                WHERE id = :id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'payment_status' => $payment_status,
            'momo_trans_id'  => $momo_trans_id,
            'id'             => $id,
        ]);
    }

    /**
     * Huỷ đơn và hoàn lại số lượng vào kho, gói trong một transaction.
     *
     * Chỉ huỷ được đơn đang chờ xác nhận. Truyền $user_id để người dùng
     * chỉ huỷ được đơn của chính mình; khu quản trị thì bỏ trống.
     *
     * @return bool true nếu đã huỷ, false nếu đơn không tồn tại hoặc không còn huỷ được
     */
    public function cancel($id, $user_id = null) {
        $this->pdo->beginTransaction();

        try {
            $sql = "SELECT id FROM `orders` WHERE id = :id AND status = 'pending'";
            $params = ['id' => $id];

            if ($user_id !== null) {
                $sql .= ' AND user_id = :user_id';
                $params['user_id'] = $user_id;
            }

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);

            if (!$stmt->fetch()) {
                $this->pdo->rollBack();
                return false;
            }

            // Hoàn số lượng về kho
            $stmt = $this->pdo->prepare(
                'SELECT product_id, quantity FROM `order_items` WHERE order_id = :order_id'
            );
            $stmt->execute(['order_id' => $id]);

            $stmtStock = $this->pdo->prepare(
                'UPDATE products SET quantity = quantity + :qty WHERE id = :id'
            );

            foreach ($stmt->fetchAll() as $item) {
                $stmtStock->execute([
                    'qty' => $item['quantity'],
                    'id'  => $item['product_id'],
                ]);
            }

            $stmt = $this->pdo->prepare("UPDATE `orders` SET status = 'cancelled' WHERE id = :id");
            $stmt->execute(['id' => $id]);

            $this->pdo->commit();
            return true;

        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }
}
