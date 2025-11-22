<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 2) {
    header("Location: login.php");
    exit;
}

if (isset($_POST['id'])) {
    $delete_id = $_POST['id'];
    $stmt = $conn->prepare("DELETE FROM events WHERE event_id = :id AND manager_id = :manager_id");
    $stmt->execute([
        ':id' => $delete_id,
        ':manager_id' => $_SESSION['user_id']
    ]);
    header("Location: index.php");
    exit;
}
?>