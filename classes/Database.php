<?php
class Database {
    protected $pdo;

    public function __construct() {
        // PostgreSQL Configuration
        $host = "localhost";
        $port = "5432";
        $dbname = "event_management";
        $username = "postgres";
        $password = "hello098";

        try {
            $this->pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die(" Database Connection Failed: " . $e->getMessage());
        }
    }

    // Encapsulation
    public function getConnection() {
        return $this->pdo;
    }
}
?>
