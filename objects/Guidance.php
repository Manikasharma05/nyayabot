<?php
class Guidance {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function read($issue_type) {
    // Validate input
    if (empty($issue_type)) {
        throw new InvalidArgumentException("Issue type cannot be empty");
    }
    
    // Normalize input
    $issue_type = strtolower(trim($issue_type));

    try {
        // Use consistent parameter naming
        $query = "SELECT step_id, issue_type, step_number, step_description 
                  FROM guidance_steps 
                  WHERE issue_type = :issue_type
                  ORDER BY step_number";
        
        $stmt = $this->conn->prepare($query);
        
        // Explicitly bind with type specification
        $stmt->bindParam(':issue_type', $issue_type, PDO::PARAM_STR);
        
        $stmt->execute();
        return $stmt;
        
    } catch (PDOException $e) {
        error_log("Guidance query failed: " . $e->getMessage());
        throw new Exception("Database operation failed");
    }
}
}
?>