<?php
require_once __DIR__ . '/db_connect.php';

class Analytics {
    private $pdo;

    public function __construct() {
        global $conn;
        $this->pdo = $conn;
    }

    public function getCounts() {
        return [
            'managers' => $this->pdo->query("SELECT COUNT(*) FROM users WHERE role_id = 2")->fetchColumn(),
            'users' => $this->pdo->query("SELECT COUNT(*) FROM users WHERE role_id = 3")->fetchColumn(), // Only role_id = 3
            'events' => $this->pdo->query("SELECT COUNT(*) FROM events")->fetchColumn(),
            'registrations' => $this->pdo->query("SELECT COUNT(*) FROM registrations")->fetchColumn(),
        ];
    }

    public function getEventStatuses() {
        return [
            'approved' => $this->pdo->query("SELECT COUNT(*) FROM events WHERE status='approved'")->fetchColumn(),
            'pending' => $this->pdo->query("SELECT COUNT(*) FROM events WHERE status='pending'")->fetchColumn(),
            'rejected' => $this->pdo->query("SELECT COUNT(*) FROM events WHERE status='rejected'")->fetchColumn(),
        ];
    }
}
?>