<?php
class OrderItem extends BaseModel {

    /**
     * Các dòng hàng của một đơn, kèm tên và ảnh sản phẩm để hiện ra màn hình.
     *
     * Dùng LEFT JOIN để đơn cũ vẫn xem được kể cả khi sản phẩm đã bị xoá.
     * Giá lấy từ chính bảng order_items — là giá tại thời điểm đặt, không
     * phải giá hiện tại của sản phẩm.
     */
    public function getByOrderID($order_id) {
        $sql = 'SELECT itm.*, pro.name as product_name, pro.image as product_image
            FROM `order_items` as itm
            LEFT JOIN products as pro ON itm.product_id = pro.id
            WHERE itm.order_id = :order_id
            ORDER BY itm.id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['order_id' => $order_id]);
        return $stmt->fetchAll();
    }

    /**
     * Tổng số món trong một đơn, dùng cho danh sách đơn hàng.
     */
    public function countByOrderID($order_id) {
        $sql = 'SELECT IFNULL(SUM(quantity), 0) FROM `order_items` WHERE order_id = :order_id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['order_id' => $order_id]);
        return (int) $stmt->fetchColumn();
    }

    /**
     * Số lượng đã bán của một sản phẩm, không tính đơn đã huỷ.
     */
    public function countSoldByProductID($product_id) {
        $sql = "SELECT IFNULL(SUM(itm.quantity), 0)
            FROM `order_items` as itm
            JOIN `orders` as ord ON itm.order_id = ord.id
            WHERE itm.product_id = :product_id AND ord.status <> 'cancelled'";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['product_id' => $product_id]);
        return (int) $stmt->fetchColumn();
    }
}
