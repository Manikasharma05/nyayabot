<?php
ini_set('error_log', 'C:/xampp/apache/logs/nyayabot_errors.log');

ini_set('log_errors', 1);
error_reporting(E_ALL);


header("Cache-Control: max-age=3600");
header('Content-Type: application/json');

try {
    include_once '../config/constants.php';
    include_once '../config/database.php';
    include_once '../objects/Guidance.php';

    // Initialize database connection
    $database = new Database();
    $db = $database->getConnection();
    if (!$db) {
        throw new Exception("Database connection failed");
    }

    // Get and validate input
    $issue_type = $_GET['issue_type'] ?? 'property';
    if (empty($issue_type)) {
        throw new InvalidArgumentException("Issue type cannot be empty");
    }

    // Fetch guidance data
    $guidance = new Guidance($db);
    $stmt = $guidance->read($issue_type);
    
    // Check and return results
    if ($stmt->rowCount() > 0) {
        echo json_encode([
            "steps" => $stmt->fetchAll(PDO::FETCH_ASSOC)
        ]);
    } else {
        echo json_encode([
            "error" => "No guidance found for '" . htmlspecialchars($issue_type) . "'"
        ]);
    }

} catch (InvalidArgumentException $e) {
    http_response_code(400); // Bad request
    echo json_encode(["error" => $e->getMessage()]);
    error_log("Guidance.php input error: " . $e->getMessage());
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => "Database error"]);
    error_log("Guidance.php database error: " . $e->getMessage());
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["error" => "Server error: " . $e->getMessage()]);
    error_log("Guidance.php error: " . $e->getMessage());
}
?>