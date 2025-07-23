<?php
include_once '../config/constants.php';
include_once '../config/database.php';
include_once '../objects/Guidance.php';

$database = new Database();
$db = $database->getConnection();
$guidance = new Guidance($db);

$issue_type = $_GET['issue_type'] ?? 'property'; // Default to property disputes
$stmt = $guidance->read($issue_type);
$steps = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode(["steps" => $steps]);
?>