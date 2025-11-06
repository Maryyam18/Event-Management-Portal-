<?php
include 'dbconnection.php';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && isset($_POST['event_id'])) {
    $event_id = $_POST['event_id'];
    
    if ($_POST['action'] === 'approve') {
        if (approve($event_id)) {
            
            header("Location: manager_approval.php?success=approved");
        } else {
            header("Location: manager_approval.php?error=approval_failed");
        }
    } elseif ($_POST['action'] === 'reject') {
        if (reject($event_id)) {
            header("Location: manager_approval.php?success=rejected");
        } else {
            header("Location: manager_approval.php?error=rejection_failed");
        }
    }
    exit();
}

function approve($event_id) {
    global $conn;
    try {
        $stmt = $conn->prepare("UPDATE registrations SET status='approved' WHERE registration_id = :event_id");
        $stmt->execute(['event_id' => $event_id]);
        return true;
    } catch(PDOException $e) {
        error_log("Approval Error: " . $e->getMessage());
        return false;
    }
}

function reject($event_id) {
    global $conn;
    try {
        $stmt = $conn->prepare("UPDATE registrations SET status='rejected' WHERE registration_id  = :event_id");
        $stmt->execute(['event_id' => $event_id]);
        return true;
    } catch(PDOException $e) {
        error_log("Rejection Error: " . $e->getMessage());
        return false;
    }
}