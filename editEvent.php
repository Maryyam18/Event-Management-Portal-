<?php
include 'dbconnection.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['event_id'];

    if (!empty($id)) {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $location = $_POST['location'];
        $event_time = $_POST['event_time'];
        $people_limit = $_POST['people_limit'];
        $budget = $_POST['budget'];
    

        $stmt = $conn->prepare("UPDATE events 
            SET title = :title, description = :description, location = :location, 
                event_time = :event_time, people_limit = :people_limit, 
                budget = :budget 
            WHERE event_id = :id");

        $stmt->execute([
            ':title' => $title,
            ':description' => $description,
            ':location' => $location,
            ':event_time' => $event_time,
            ':people_limit' => $people_limit,
            ':budget' => $budget,
            ':id' => $id
        ]);
    }

    header("Location: index.php");
    exit;
}
?>