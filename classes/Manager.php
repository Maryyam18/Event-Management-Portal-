<?php
require_once __DIR__ . '/User.php';

class Manager extends User {
    public function __construct($full_name = '', $password = '') {
        parent::__construct($full_name, $password, 2); // Fixed role_id = 2 for managers
    }

    // Create
    public function save() {
        $stmt = $this->pdo->prepare("SELECT user_id FROM users WHERE full_name = ?");
        $stmt->execute([$this->full_name]);
        if ($stmt->fetch()) {
            throw new Exception("Name already taken.");
        }
        $hash = password_hash($this->password, PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare("INSERT INTO users (full_name, password, role_id) VALUES (?, ?, ?)");
        $stmt->execute([$this->full_name, $hash, 2]); // Hardcode role_id = 2
    }

    // Read
    public function getAll() {
        $stmt = $this->pdo->prepare("SELECT user_id, full_name, role_id FROM users WHERE role_id = 2 ORDER BY user_id ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Update
    public function update($id, $full_name, $password) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare("UPDATE users SET full_name = ?, password = ? WHERE user_id = ? AND role_id = 2");
        $stmt->execute([$full_name, $hash, $id]);
    }

    // Delete
    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM users WHERE user_id = ? AND role_id = 2");
        $stmt->execute([$id]);
    }
}
?>