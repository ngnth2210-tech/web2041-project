<?php
class User extends BaseModel {
    protected $tableName = 'users';

    public function getAll() {
        $sql = "SELECT * FROM {$this->tableName} ORDER BY id DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function find(int $id) {
        $sql = "SELECT * FROM users WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }


    public function update($id, $data): void
    {
        $sql = "UPDATE users SET username = :username, email = :email WHERE id = :id";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'username' => $data['username'], 
            'email'    => $data['email'], 
            'id'       => $id
        ]);
    }

    public function updateStatus(int $id, int $status)  {
        $sql = "UPDATE users SET status = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$status, $id]);
    }

    public function getUserByUsername($username)  {
        $sql = "SELECT * FROM users 
            WHERE username = :key OR email = :key
            LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['key' => $username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function checkUserExists($username, $email)  {
        $sql = "SELECT COUNT(*) FROM users WHERE username = ? OR email = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$username, $email]);
        return $stmt->fetchColumn() > 0;
    }

    public function insertUser($username, $email, $password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    
        $sql = "INSERT INTO users (username, email, password, is_main, status) VALUES (?, ?, ?, 0, 1)"; 
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$username, $email, $hashedPassword]);
        return $this->pdo->lastInsertId();
    }
}
?>