<?php
require_once 'User.php';

class Manager extends User {
    public function __construct($full_name = '', $email = '', $password = '') {
        parent::__construct($full_name, $email, $password, 2); // role_id = 2 for manager
    }

    // Create
    public function save() {
        $stmt = $this->pdo->prepare("INSERT INTO users (full_name,  password, role_id) VALUES (:name, :password, :role_id)");
        $stmt->execute([
            ':name' => $this->full_name,
            ':password' => $this->password,
            ':role_id' => $this->role_id
        ]);
    }

    // Read
    public function getAll() {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE role_id = 2 ORDER BY user_id ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Update
    public function update($id, $full_name, $email, $password) {
        $stmt = $this->pdo->prepare("UPDATE users SET full_name = :name, password = :password WHERE user_id = :id");
        $stmt->execute([
            ':name' => $full_name,
            ///':email' => $email,
            ':password' => $password,
            ':id' => $id
        ]);
    }

    // Delete
    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM users WHERE user_id = :id");
        $stmt->execute([':id' => $id]);
    }
}
?>
