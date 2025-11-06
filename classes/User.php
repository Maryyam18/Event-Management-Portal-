<?php
require_once 'Database.php';  // Include database class

class User extends Database {
    protected $user_id;
    protected $full_name;
    protected $email;
    protected $password;
    protected $role_id;

    public function __construct($full_name = '', $email = '', $password = '', $role_id = 0) {
        parent::__construct(); // Call Database constructor
        $this->full_name = $full_name;
        $this->email = $email;
        $this->password = $password;
        $this->role_id = $role_id;
    }

    // Common function: fetch all users
    public function getAllUsers() {
        $stmt = $this->pdo->prepare("SELECT * FROM users");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
