<?php
error_log("Test log entry at " . date('Y-m-d H:i:s')); // Test log
ini_set('display_errors', 0);
header("Content-Type: application/json");

// Define base path and check files
$configPath = dirname(__DIR__, 2) . '/config/';
$objectsPath = dirname(__DIR__, 2) . '/objects/';
$files = [
    'constants.php' => $configPath . 'constants.php',
    'database.php' => $configPath . 'database.php',
    'User.php' => $objectsPath . 'User.php'
];

foreach ($files as $file => $path) {
    if (!file_exists($path)) {
        error_log("File not found: $path at " . date('Y-m-d H:i:s'));
        http_response_code(500);
        echo json_encode(["message" => "Internal server error: File $file not found"]);
        exit;
    }
}

include_once $files['constants.php'];
include_once $files['database.php'];
include_once $files['User.php'];

// Test database connection
try {
    $database = new Database();
    $db = $database->getConnection();
    if (!$db) {
        throw new PDOException("Database connection failed");
    }
    // Test a simple query to verify connection
    $db->query("SELECT 1")->execute();
    error_log("Database connection and query test successful at " . date('Y-m-d H:i:s'));
} catch (PDOException $e) {
    error_log("Database connection error: " . $e->getMessage() . " | Trace: " . $e->getTraceAsString() . " at " . date('Y-m-d H:i:s'));
    http_response_code(500);
    echo json_encode(["message" => "Internal server error: Database connection failed"]);
    exit;
}

$user = new User($db);

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->email) && !empty($data->password)) {
    $user->email = $data->email;
    $query = "SELECT user_id, email, password FROM " . $user->table_name . " WHERE email = :email"; // Use User.php table_name
    $stmt = $db->prepare($query);

    try {
        $stmt->execute(['email' => $data->email]);
        error_log("Query executed for email: $data->email at " . date('Y-m-d H:i:s'));
        if ($stmt->rowCount() > 0) {
            $user_data = $stmt->fetch(PDO::FETCH_ASSOC);
            error_log("Login attempt for email: $data->email, hashed password: " . $user_data['password'] . " at " . date('Y-m-d H:i:s'));
            if (password_verify($data->password, $user_data['password'])) {
                http_response_code(200);
                echo json_encode(["message" => "Login successful", "user_id" => $user_data['user_id'], "email" => $user_data['email']]);
            } else {
                error_log("Password verification failed for email: $data->email at " . date('Y-m-d H:i:s'));
                http_response_code(401);
                echo json_encode(["message" => "Invalid email or password"]);
            }
        } else {
            error_log("Email not found: $data->email at " . date('Y-m-d H:i:s'));
            http_response_code(401);
            echo json_encode(["message" => "Invalid email or password"]);
        }
    } catch (PDOException $e) {
        error_log("Database query error: " . $e->getMessage() . " | Trace: " . $e->getTraceAsString() . " at " . date('Y-m-d H:i:s'));
        http_response_code(500);
        echo json_encode(["message" => "Internal server error: Database query failed"]);
    }
} else {
    error_log("Incomplete login data: " . print_r($data, true) . " at " . date('Y-m-d H:i:s'));
    http_response_code(400);
    echo json_encode(["message" => "Incomplete data"]);
}
?>