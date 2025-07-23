<?php
include_once '../config/constants.php';
include_once '../config/database.php';
include_once '../objects/FirTemplate.php';

$database = new Database();
$db = $database->getConnection();
$template = new FirTemplate($db);

// GET all templates
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $stmt = $template->read();
    $templates = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(["templates" => $templates]);
}

// Increment download count (PUT request)
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $data = json_decode(file_get_contents("php://input"));
    if ($template->incrementDownload($data->id)) {
        echo json_encode(["message" => "Download counted"]);
    }
}
?>