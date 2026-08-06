<?php
class Order extends BaseModel {
    protected $tableName = 'orders';

    // Thứ tự trạng thái — chỉ được tiến về phía trước
    public static $statusFlow = [
        'pending'   => 0,
        'confirmed' => 1,
        'shipping'  => 2,
        'completed' => 3,
        'cancelled' => 99, // đặc biệt — luôn cho phép từ pending/confirmed/shipping
    ];

    /**
     * Kiểm tra có được phép chuyển từ $from → $to không.
     * Quy tắc:
     *  - Chỉ tiến lên (index mới > index cũ)
     *  - Hoặc chuyển sang cancelled (trừ khi đã completed)
     *  - Không được quay lại trạng thái trước
     */
    public static function canTransition($from, $to): bool {
        $flow = self::$statusFlow;

        // Đã completed hoặc cancelled rồi → không đổi nữa
        if (in_array($from, ['completed', 'cancelled'])) return false;

        // Cho phép hủy từ pending / confirmed / shipping
        if ($to === 'cancelled') return true;

        // Chỉ cho tiến về phía trước
        if (!isset($flow[$from], $flow[$to])) return false;
        return $flow[$to] > $flow[$from];
    }

    /**
     * Các trạng thái được phép chuyển tới từ trạng thái hiện tại.
     */
    public static function allowedNextStatuses($current): array {
        if (in_array($current, ['completed', 'cancelled'])) return [];

        $next = [];
        foreach (self::$statusFlow as $status => $idx) {
            if (self::canTransition($current, $status)) {
                $next[] = $status;
            }
        }
        return $next;
    }

    // Lấy toàn bộ đơn hàng kèm số lượng sản phẩm
    public function getAll() {
        $sql = "
            SELECT o.*, COUNT(oi.id) AS total_items
            FROM orders AS o
            LEFT JOIN order_items AS oi ON o.id = oi.order_id
            GROUP BY o.id
            ORDER BY o.id DESC
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Lấy đơn hàng của 1 user cụ thể
    public function getByUserId($user_id) {
        $sql = "
            SELECT o.*, COUNT(oi.id) AS total_items
            FROM orders AS o
            LEFT JOIN order_items AS oi ON o.id = oi.order_id
            WHERE o.user_id = :user_id
            GROUP BY o.id
            ORDER BY o.id DESC
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['user_id' => $user_id]);
        return $stmt->fetchAll();
    }

    // Lấy 1 đơn hàng theo id
    public function find($id) {
        $sql  = "SELECT * FROM orders WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    // Lấy danh sách sản phẩm thuộc 1 đơn hàng
    public function getOrderItems($order_id) {
        $sql = "
            SELECT oi.*, p.name AS product_name, p.image AS product_image
            FROM order_items AS oi
            JOIN products AS p ON oi.product_id = p.id
            WHERE oi.order_id = :order_id
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['order_id' => $order_id]);
        return $stmt->fetchAll();
    }

    // Tạo đơn hàng mới
    public function insert($data) {
        $sql = "
            INSERT INTO orders
                (user_id, customer_name, customer_phone, customer_address, note, total_price, status, created_at)
            VALUES
                (:user_id, :customer_name, :customer_phone, :customer_address, :note, :total_price, 'pending', NOW())
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'user_id'          => $data['user_id'] ?? null,
            'customer_name'    => $data['customer_name'],
            'customer_phone'   => $data['customer_phone'],
            'customer_address' => $data['customer_address'],
            'note'             => $data['note'] ?? '',
            'total_price'      => $data['total_price'],
        ]);
        return $this->pdo->lastInsertId();
    }

    // Thêm 1 dòng order_item
    public function insertItem($data) {
        $sql = "INSERT INTO order_items (order_id, product_id, quantity, price)
                VALUES (:order_id, :product_id, :quantity, :price)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'order_id'   => $data['order_id'],
            'product_id' => $data['product_id'],
            'quantity'   => $data['quantity'],
            'price'      => $data['price'],
        ]);
    }

    // Cập nhật trạng thái
    public function updateStatus($id, $status) {
        $sql  = "UPDATE orders SET status = :status WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['status' => $status, 'id' => $id]);
    }


    // Đánh dấu đơn đang chờ thanh toán MoMo
    public function setPaymentPending(int $id, string $method): void {
        $sql = "UPDATE orders SET payment_method = :method, payment_status = 'pending' WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['method' => $method, 'id' => $id]);
    }

    // Cập nhật khi MoMo xác nhận thanh toán thành công
    public function setPaymentSuccess(int $id, string $transId): void {
        $sql = "UPDATE orders SET payment_status = 'paid', momo_trans_id = :trans_id, status = 'pending' WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['trans_id' => $transId, 'id' => $id]);
    }

    // Xóa đơn hàng
    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM order_items WHERE order_id = :id");
        $stmt->execute(['id' => $id]);
        $stmt = $this->pdo->prepare("DELETE FROM orders WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }
}
?>
