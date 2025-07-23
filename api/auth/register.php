<?php
header("Content-Type: application/json");

// Database connection
$host = '127.0.0.1';
$db   = 'nyayabot_db';
$user = 'root';
$pass = 'root123';
$charset = 'utf8mb4';
$port = '3307';

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$db;charset=$charset", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Verify table exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'users'");
    if ($stmt->rowCount() == 0) {
        error_log("Table 'users' does not exist in database '$db'");
        http_response_code(500);
        echo json_encode(["message" => "Database error: Table 'users' does not exist"]);
        exit;
    }
    
    // Get input data
    $data = json_decode(file_get_contents("php://input"), true);
    
    // Validate
    if (empty($data['email']) || empty($data['password']) || empty($data['name']) || empty($data['phone'])) {
        error_log("Missing fields: " . print_r($data, true));
        http_response_code(400);
        echo json_encode(["message" => "All fields (email, password, name, phone) are required"]);
        exit;
    }
    
    // Check if email exists
    $stmt = $pdo->prepare("SELECT user_id FROM users WHERE email = :email");
    $stmt->execute(['email' => $data['email']]);
    
    if ($stmt->rowCount() > 0) {
        error_log("Email already exists: " . $data['email']);
        http_response_code(409);
        echo json_encode(["message" => "Email already exists"]);
        exit;
    }
    
    // Insert new user
    $stmt = $pdo->prepare("INSERT INTO users (email, password, name, phone, created_at, updated_at) VALUES (:email, :password, :name, :phone, NOW(), NOW())");
    $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
    
    if ($stmt->execute([
        'email' => $data['email'],
        'password' => $hashedPassword,
        'name' => $data['name'],
        'phone' => $data['phone']
    ])) {
        error_log("User registered successfully: " . $data['email']);
        http_response_code(201);
        echo json_encode(["message" => "User registered successfully"]);
    } else {
        error_log("Insert failed for email: " . $data['email']);
        throw new PDOException("Insert failed");
    }
    
} catch(PDOException $e) {
    error_log("Database error: " . $e->getMessage() . " | Trace: " . $e->getTraceAsString());
    http_response_code(500);
    echo json_encode(["message" => "Database error: " . $e->getMessage()]);
} catch(Exception $e) {
    error_log("General error: " . $e->getMessage() . " | Trace: " . $e->getTraceAsString());
    http_response_code(500);
    echo json_encode(["message" => "Server error: " . $e->getMessage()]);
}
?>