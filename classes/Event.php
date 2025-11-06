<?php
require_once __DIR__ . '/Database.php';

class Event {
    private $pdo;

    public function __construct() {
        $db = new Database();
        $this->pdo = $db->getConnection();
    }

    // ✅ Get all events with manager names
    public function getAll() {
        $sql = "SELECT e.*, u.full_name AS manager_name 
                FROM events e 
                LEFT JOIN users u ON e.manager_id = u.user_id
                ORDER BY e.event_id DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ✅ Approve event
    public function approve($id) {
        $stmt = $this->pdo->prepare("UPDATE events SET status='approved', approved_at=NOW() WHERE event_id=:id");
        $stmt->execute(['id' => $id]);
    }

    // ✅ Reject event
    public function reject($id) {
        $stmt = $this->pdo->prepare("UPDATE events SET status='rejected', approved_at=NOW() WHERE event_id=:id");
        $stmt->execute(['id' => $id]);
    }
}
?>
