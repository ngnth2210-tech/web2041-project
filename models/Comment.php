<?php

class Comment extends BaseModel
{
    // Lấy tất cả bình luận cho trang quản trị
    public function getAll()
    {
        $sql = "SELECT 
                    c.id,
                    c.content,
                    c.created_at,
                    c.status,
                    u.username,
                    p.name AS product_name
                FROM comments AS c
                JOIN users AS u ON c.user_id = u.id
                JOIN products AS p ON c.product_id = p.id
                ORDER BY c.created_at DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    // Lấy bình luận của một sản phẩm
    public function getCommentsByProductID($product_id)
    {
        $sql = "SELECT 
                    c.*,
                    u.username AS user_name
                FROM comments AS c
                JOIN users AS u ON c.user_id = u.id
                WHERE c.product_id = :product_id
                AND c.status = 1
                ORDER BY c.created_at DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'product_id' => $product_id
        ]);

        return $stmt->fetchAll();
    }

    // Thêm bình luận
    public function insertComment($product_id, $user_id, $content)
    {
        $sql = "INSERT INTO comments
                (product_id, user_id, content, status)
                VALUES (?, ?, ?, 1)";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            $product_id,
            $user_id,
            $content
        ]);
    }

    // Xóa bình luận
    public function delete($id)
    {
        $sql = "DELETE FROM comments WHERE id = ?";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([$id]);
    }

    // Ẩn / hiện bình luận
    public function update($id, $status)
    {
        $sql = "UPDATE comments
                SET status = ?
                WHERE id = ?";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            $status,
            $id
        ]);
    }
}