<?php
class User {
    private $conn;
    public $table_name = "users";

    public $user_id;
    public $email;
    public $password;
    public $name;
    public $phone;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function emailExists() {
        $query = "SELECT user_id, email, password FROM " . $this->table_name . " WHERE email = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$this->email]);
        return $stmt->rowCount() > 0 ? $stmt->fetch(PDO::FETCH_ASSOC) : false;
    }

    public function create() {
        if ($this->emailExists()) {
            return false; // Email already exists
        }

        $query = "INSERT INTO " . $this->table_name . " (email, password, name, phone, created_at, updated_at) VALUES (:email, :password, :name, :phone, NOW(), NOW())";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':password', $this->password);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':phone', $this->phone);

        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error in create(): " . $e->getMessage());
            return false;
        }
    }
}
?>