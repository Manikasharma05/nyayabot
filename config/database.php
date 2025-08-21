<?php
require dirname(__DIR__) . '/vendor/autoload.php';// Use existing Composer autoload

use Dotenv\Dotenv;

class Database {
    private $host;
    private $port;
    private $db_name;
    private $username;
    private $password;
    public $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            $dotenv = Dotenv::createImmutable(__DIR__ . '/..'); // Path to .env in project root
            $dotenv->load();

            $this->host = $_ENV['DB_HOST'] ?? "127.0.0.1";
            $this->port = $_ENV['DB_PORT'] ?? "3307";
            $this->db_name = $_ENV['DB_NAME'] ?? "nyayabot_db";
            $this->username = $_ENV['DB_USER'] ?? "root";
            $this->password = $_ENV['DB_PASS'] ?? "root123";

            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->db_name . ";charset=utf8mb4",
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            error_log("Database connection successful at " . date('Y-m-d H:i:s'));
        } catch (PDOException $e) {
            error_log("Connection error: " . $e->getMessage() . " | Trace: " . $e->getTraceAsString() . " at " . date('Y-m-d H:i:s'));
            // Allow exception propagation
        }
        return $this->conn;
    }
}
?>