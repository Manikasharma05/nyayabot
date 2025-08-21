<?php
// Set headers first
header("Content-Type: application/json");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Expires: Thu, 01 Jan 1970 00:00:00 GMT");
header("Pragma: no-cache");

// Initialize secure session (make 'secure' conditional for dev vs prod)
$isHttps = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on';
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'domain' => $_SERVER['HTTP_HOST'],
    'secure' => $isHttps,
    'httponly' => true,
    'samesite' => 'Strict'
]);

session_start();

// Destroy session completely
$_SESSION = [];
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}
session_destroy();

// Return success response
http_response_code(200);
echo json_encode([
    'status' => 'success',
    'message' => 'Logged out successfully',
    'timestamp' => time()
]);
exit;
?>