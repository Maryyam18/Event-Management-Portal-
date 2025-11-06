<?php
session_start();
if (isset($_SESSION['user_id'])) { // Control Statements: if
    session_destroy(); // Operators: isset
    header("Location: login.php");
    exit;
}
?>