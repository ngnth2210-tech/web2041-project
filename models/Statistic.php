<?php
class Statistic extends BaseModel
{

    public function getTotalRevenue()
    {
        $sql = "SELECT COALESCE(SUM(total_price), 0) AS revenue FROM orders WHERE status = 'completed'";
        return $this->pdo->query($sql)->fetchColumn();
    }

    public function getTotalOrders()
    {
        return $this->pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn();
    }

    public function getTotalProducts()
    {
        return $this->pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
    }

    public function getTotalUsers()
    {
        return $this->pdo->query("SELECT COUNT(*) FROM users WHERE is_main = 0")->fetchColumn();
    }

    public function getOrdersByStatus()
    {
        $sql  = "SELECT status, COUNT(*) AS total FROM orders GROUP BY status";
        $rows = $this->pdo->query($sql)->fetchAll();
        $map  = [];
        foreach ($rows as $r) $map[$r['status']] = (int)$r['total'];
        return $map;
    }

    public function getRevenueByMonth()
    {
        $sql = "
            SELECT DATE_FORMAT(created_at, '%Y-%m') AS month,
                   COALESCE(SUM(total_price), 0)    AS revenue
            FROM orders
            WHERE status = 'completed'
              AND created_at >= DATE_SUB(NOW(), INTERVAL 12 MONTH)
            GROUP BY month
            ORDER BY month ASC
        ";
        return $this->pdo->query($sql)->fetchAll();
    }

    public function getOrdersByDay()
    {
        $sql = "
            SELECT DATE(created_at) AS day, COUNT(*) AS total
            FROM orders
            WHERE created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)
            GROUP BY day
            ORDER BY day ASC
        ";
        return $this->pdo->query($sql)->fetchAll();
    }

    public function getTopProducts($limit = 5)
    {
        $sql = "
            SELECT p.id, p.name, p.image, p.price,
                   COALESCE(SUM(oi.quantity), 0) AS sold
            FROM products p
            LEFT JOIN order_items oi ON p.id = oi.product_id
            LEFT JOIN orders o ON oi.order_id = o.id AND o.status = 'completed'
            GROUP BY p.id, p.name, p.image, p.price
            ORDER BY sold DESC
            LIMIT :limit
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getLatestOrders($limit = 8)
    {
        $sql = "
            SELECT id, customer_name, total_price, status, created_at
            FROM orders ORDER BY id DESC LIMIT :limit
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getRevenueToday()
    {
        $sql = "SELECT COALESCE(SUM(total_price),0) FROM orders
                WHERE status='completed' AND DATE(created_at)=CURDATE()";
        return $this->pdo->query($sql)->fetchColumn();
    }

    public function getRevenueThisMonth()
    {
        $sql = "SELECT COALESCE(SUM(total_price),0) FROM orders
                WHERE status='completed'
                  AND MONTH(created_at)=MONTH(NOW())
                  AND YEAR(created_at)=YEAR(NOW())";
        return $this->pdo->query($sql)->fetchColumn();
    }

    public function getProductsByCategory()
    {
        $sql = "
            SELECT c.name, COUNT(p.id) AS total
            FROM categories c
            LEFT JOIN products p ON c.id = p.category_id
            GROUP BY c.id, c.name
            ORDER BY total DESC
        ";
        return $this->pdo->query($sql)->fetchAll();
    }
}
