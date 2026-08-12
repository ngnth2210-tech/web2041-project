<?php
class Comment extends BaseModel {

    /**
     * Lấy bình luận đã duyệt của một sản phẩm, kèm tên người viết.
     */
    public function getByProductID($product_id) {
        $sql = 'SELECT cmt.*, usr.username
            FROM `comments` as cmt
            JOIN users as usr ON cmt.user_id = usr.id
            WHERE cmt.product_id = :product_id AND cmt.status = 1
            ORDER BY cmt.id DESC';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['product_id' => $product_id]);
        return $stmt->fetchAll();
    }

    public function insert($product_id, $user_id, $content) {
        $sql = "INSERT INTO `comments` (`product_id`, `user_id`, `content`) VALUES
        (:product_id, :user_id, :content)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'product_id' => $product_id,
            'user_id'    => $user_id,
            'content'    => $content,
        ]);
    }

    public function countByProductID($product_id) {
        $sql = 'SELECT COUNT(*) FROM `comments` WHERE product_id = :product_id AND status = 1';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['product_id' => $product_id]);
        return (int) $stmt->fetchColumn();
    }
}
