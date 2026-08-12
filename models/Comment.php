<?php

class Comment extends BaseModel
{
    protected $table = 'comments';

    /**
     * Lấy danh sách bình luận theo sản phẩm
     */
    public function getByProductID($product_id)
    {
        $sql = "
            SELECT 
                c.*,
                u.username,
                p.name AS product_name
            FROM comments c
            LEFT JOIN users u ON c.user_id = u.id
            LEFT JOIN products p ON c.product_id = p.id
            WHERE c.product_id = ?
              AND c.status = 1
            ORDER BY c.created_at DESC
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$product_id]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Lấy toàn bộ bình luận cho ADMIN
     */
    public function getAll()
    {
        $sql = "
            SELECT 
                c.*,
                u.username,
                p.name AS product_name
            FROM comments c
            LEFT JOIN users u ON c.user_id = u.id
            LEFT JOIN products p ON c.product_id = p.id
            ORDER BY c.created_at DESC
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Thêm bình luận
     */
    public function insert($product_id, $user_id, $content)
    {
        $sql = "
            INSERT INTO comments
                (product_id, user_id, content, status, created_at)
            VALUES
                (?, ?, ?, 1, NOW())
        ";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            $product_id,
            $user_id,
            $content
        ]);
    }

    /**
     * Đổi trạng thái bình luận
     * 1 = Hiển thị
     * 0 = Ẩn
     */
    public function updateStatus($id, $status)
    {
        $sql = "
            UPDATE comments
            SET status = ?
            WHERE id = ?
        ";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            $status,
            $id
        ]);
    }

    /**
     * Hàm update dùng cho CommentController
     * Tránh lỗi: Call to undefined method Comment::update()
     */
    public function update($id, $status)
    {
        return $this->updateStatus($id, $status);
    }

    /**
     * Xóa bình luận
     */
    public function delete($id)
    {
        $sql = "
            DELETE FROM comments
            WHERE id = ?
        ";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([$id]);
    }

    /**
     * Lấy 1 bình luận
     */
    public function find($id)
    {
        $sql = "
            SELECT 
                c.*,
                u.username,
                p.name AS product_name
            FROM comments c
            LEFT JOIN users u ON c.user_id = u.id
            LEFT JOIN products p ON c.product_id = p.id
            WHERE c.id = ?
            LIMIT 1
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
} 