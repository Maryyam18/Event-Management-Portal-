<?php
require_once __DIR__ . '/Database.php';

class Analytics {
    private $pdo;

    public function __construct() {
        $db = new Database();
        $this->pdo = $db->getConnection();
    }

    public function getCounts() {
        return [
            'managers' => $this->pdo->query("SELECT COUNT(*) FROM users WHERE role_id = 2")->fetchColumn(),
            'users' => $this->pdo->query("SELECT COUNT(*) FROM users")->fetchColumn(),
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
