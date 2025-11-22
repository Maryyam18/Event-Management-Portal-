<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 2) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $location = $_POST['location'];
    $event_time = $_POST['event_time'];
    $people_limit = $_POST['people_limit'];
    $budget = $_POST['budget'];
    $speakers = $_POST['speakers'];
    $status = 'pending';
    $manager_id = $_SESSION['user_id'];
    $approved_by = null;

    $stmt = $conn->prepare("INSERT INTO events (
        title, description, location, event_time, people_limit, budget, speakers, status, manager_id, approved_by
    ) VALUES (:title, :description, :location, :event_time, :people_limit, :budget, :speakers, :status, :manager_id, :approved_by)");
    
    $stmt->execute([
        ':title' => $title,
        ':description' => $description,
        ':location' => $location,
        ':event_time' => $event_time,
        ':people_limit' => $people_limit,
        ':budget' => $budget,
        ':speakers' => $speakers,
        ':status' => $status,
        ':manager_id' => $manager_id,
        ':approved_by' => $approved_by,
    ]);
    
    header("Location: index.php");
    exit;
}
?>