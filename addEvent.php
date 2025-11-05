<?php
include 'dbconnection.php';

// ADD EVENT
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $title = $_POST['title'];
    $description = $_POST['description'];
    $location = $_POST['location'];
    $event_time = $_POST['event_time'];
    $people_limit = $_POST['people_limit'];
    $budget = $_POST['budget'];
    $status = 'pending';
    $manager_id=1 ;
    $approved_by= 1;
////INSERT INTO events 
    $stmt = $conn->prepare("INSERT INTO events (
     title, description, location, event_time,
    people_limit, budget, status, manager_id,
    approved_by)
  VALUES (:title, :description, :location, :event_time, :people_limit, :budget,:status,:manager_id,:approved_by)");
       
    //    $stmt->execute(); // No parameters needed
       
       
    //    --   
    $stmt->execute([
        ':title' => $title,
        ':description' => $description,
        ':location' => $location,
        ':event_time' => $event_time,
        ':people_limit' => $people_limit,
        ':budget' => $budget,
        ':status' => $status,
        ':manager_id' => $manager_id,
        ':approved_by' => $approved_by,

    ]);

    header("Location: index.php");
    exit;
}
//EDIT

// else 
