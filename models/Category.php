<?php
class Category extends BaseModel {
    protected $tableName = 'categories';

    public function getAll() {
        $sql = "SELECT * FROM {$this->tableName} ORDER BY id DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function find($id) {
        $sql = "SELECT * FROM categories WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function insert($name, $description = null) {
        $sql = "INSERT INTO `categories` (`name`, `description`) VALUES (?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$name, $description]);
    }

    public function update($id, $name) {
        $sql = "UPDATE categories SET name = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$name, $id]);
    }

    // Thay delete = toggleStatus
    public function toggleStatus($id) {
        $sql = "UPDATE categories SET status = IF(IFNULL(status,1) = 1, 0, 1) WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
    }

    public function delete($id) {
        $sql = "DELETE FROM categories WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
    }
}
?>
