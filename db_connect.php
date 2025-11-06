<?php
$host = "localhost";
$port = "5432";
$dbname = "event_management";
$user = "postgres";
$password = "hello098";

try {
    $conn = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "<!-- Database connection successful -->"; // For demo visibility
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>