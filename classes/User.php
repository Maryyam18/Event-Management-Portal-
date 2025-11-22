<?php
require_once __DIR__ . '/db_connect.php';

class User {
    protected $user_id;
    protected $full_name;
    protected $password;
    protected $role_id;

    public function __construct($full_name = '', $password = '', $role_id = 0) {
        global $conn;
        $this->pdo = $conn; // Use global $conn from db_connect.php
        $this->full_name = $full_name;
        $this->password = $password;
        $this->role_id = $role_id;
    }

    // Common function: fetch all users
    public function getAllUsers() {
        $stmt = $this->pdo->prepare("SELECT user_id, full_name, role_id FROM users");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>