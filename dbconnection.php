<?php 
$host = "localhost";
$port="5432";
$dbname="event_management_db";
$user="postgres";
$password="Hans@2005";
try{
    $conn=new PDO("pgsql:host=$host;port=$port;dbname=$dbname",$user,$password);
    $conn-> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    ///echo"Database connection is success";

}
catch(PDOException $e){
    die("Connection failed  $e");

}
?>