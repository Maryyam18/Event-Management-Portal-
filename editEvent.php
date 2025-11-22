<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 2) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['event_id'];
    if (!empty($id)) {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $location = $_POST['location'];
        $event_time = $_POST['event_time'];
        $people_limit = $_POST['people_limit'];
        $budget = $_POST['budget'];
        $speakers = $_POST['speakers'];

        $stmt = $conn->prepare("UPDATE events
            SET title = :title, description = :description, location = :location,
                event_time = :event_time, people_limit = :people_limit,
                budget = :budget, speakers = :speakers
            WHERE event_id = :id AND manager_id = :manager_id");
        $stmt->execute([
            ':title' => $title,
            ':description' => $description,
            ':location' => $location,
            ':event_time' => $event_time,
            ':people_limit' => $people_limit,
            ':budget' => $budget,
            ':speakers' => $speakers,
            ':id' => $id,
            ':manager_id' => $_SESSION['user_id']
        ]);
    }
    header("Location: index.php");
    exit;
}
?>