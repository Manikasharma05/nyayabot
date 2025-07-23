<?php
class Database {
    private $host = "127.0.0.1";
    private $port = "3307"; // Added port
    private $db_name = "nyayabot_db";
    private $username = "root";
    private $password = "root123";
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->db_name . ";charset=utf8mb4",
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            error_log("Database connection successful at " . date('Y-m-d H:i:s'));
        } catch (PDOException $e) {
            error_log("Connection error: " . $e->getMessage() . " | Trace: " . $e->getTraceAsString() . " at " . date('Y-m-d H:i:s'));
            // Remove die() to allow exception propagation
        }
        return $this->conn;
    }
}
?>