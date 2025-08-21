<?php
// Set root path and verify autoloader
$rootPath = dirname(__DIR__, 2);
$vendorPath = $rootPath . '/vendor/autoload.php';

if (!file_exists($vendorPath)) {
    header("Content-Type: application/json");
    die(json_encode([
        'status' => 'error',
        'message' => 'Autoloader missing',
        'solution' => 'Run composer install'
    ]));
}

require $vendorPath;

// Initialize environment
ini_set('display_errors', 0);
error_reporting(E_ALL);
header("Content-Type: application/json");

// Secure session configuration (make 'secure' conditional for dev vs prod)
$is_https = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on';
session_set_cookie_params([
    'lifetime' => 3600, // 1 hour
    'path' => '/',
    'domain' => $_SERVER['HTTP_HOST'],
    'secure' => $isHttps,
    'httponly' => true,
    'samesite' => 'Strict'
]);

session_start();
session_regenerate_id(true);

// Enhanced logging
function logError($message, $context = []) {
    $logEntry = sprintf(
        "[%s] %s %s",
        date('Y-m-d H:i:s'),
        $message,
        !empty($context) ? json_encode($context) : ''
    );
    error_log($logEntry);
}

try {
    // Load required files
    $requiredFiles = [
        'config/constants.php',
        'config/database.php',
        'objects/User.php'
    ];

    foreach ($requiredFiles as $file) {
        $path = $rootPath . '/' . $file;
        if (!file_exists($path)) {
            throw new RuntimeException("Missing required file: $file");
        }
        require_once $path;
    }

    // Initialize database
    $database = new Database();
    $db = $database->getConnection();
    $db->query("SELECT 1")->execute(); // Test connection

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        // Session validation without DB re-check (session is already verified on login)
        if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) {
            http_response_code(200);
            echo json_encode([
                'status' => 'success',
                'user' => [
                    'user_id' => $_SESSION['user_id'],
                    'email' => $_SESSION['user_email']
                ]
            ]);
        } else {
            throw new RuntimeException("No active session", 401);
        }
        exit;
    }

    // Existing POST login logic
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Validate input
        $input = json_decode(file_get_contents("php://input"));
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new InvalidArgumentException("Invalid JSON input");
        }

        if (empty($input->email) || empty($input->password)) {
            throw new InvalidArgumentException("Email and password are required");
        }

        // Authenticate user
        $user = new User($db);
        $stmt = $db->prepare(
            "SELECT user_id, email, password 
            FROM {$user->table_name} 
            WHERE email = :email 
            LIMIT 1"
        );
        $stmt->execute([':email' => $input->email]);

        if ($stmt->rowCount() === 0) {
            throw new RuntimeException("Invalid credentials", 401);
        }

        $user_data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!password_verify($input->password, $user_data['password'])) {
            throw new RuntimeException("Invalid credentials", 401);
        }

        // Successful login
        $_SESSION = [
            'user_id' => $user_data['user_id'],
            'user_email' => $user_data['email'],
            'ip' => $_SERVER['REMOTE_ADDR'],
            'user_agent' => $_SERVER['HTTP_USER_AGENT'],
            'created' => time()
        ];

        // Regenerate session ID after login
        session_regenerate_id(true);

        http_response_code(200);
        echo json_encode([
            'status' => 'success',
            'data' => [
                'user_id' => $user_data['user_id'],
                'email' => $user_data['email']
            ],
            'session' => [
                'timeout' => 3600,
                'renew_at' => time() + 1800 // 30 minutes
            ]
        ]);
    } else {
        throw new InvalidArgumentException("Method not allowed", 405);
    }

} catch (InvalidArgumentException $e) {
    http_response_code($e->getCode() ?: 400);
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
} catch (RuntimeException $e) {
    http_response_code($e->getCode() ?: 500);
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
} catch (PDOException $e) {
    http_response_code(503);
    echo json_encode([
        'status' => 'error',
        'message' => 'Service unavailable'
    ]);
    logError("Database error", [
        'message' => $e->getMessage(),
        'trace' => $e->getTraceAsString()
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'Internal server error'
    ]);
    logError("Unexpected error", [
        'message' => $e->getMessage(),
        'trace' => $e->getTraceAsString()
    ]);
}
?>