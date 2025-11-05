


<?php
include 'dbconnection.php';if (isset($_POST['id']) ) {
    $delete_id = $_POST['id'];
    $stmt = $conn->prepare("DELETE FROM events WHERE event_id = :id");
    $stmt->bindParam(':id', $delete_id);
    $stmt->execute();
    header("Location: index.php");
    exit;
}
?>