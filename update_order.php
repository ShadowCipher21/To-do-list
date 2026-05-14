<?php
include "../db.php";
header('Content-Type: application/json');

ini_set('display_errors', 1);
error_reporting(E_ALL);

$data = json_decode(file_get_contents("php://input"), true);

if(!isset($data['tasks'])) {
    echo json_encode(["success" => false, "error" => "No tasks received"]);
    exit;
}
foreach($data['tasks'] as $task) {
    $id = intval($task['id']);
    $position = intval($task['position']);

    $stmt = $conn->prepare("UPDATE tasks SET position = ? WHERE id = ?");
    $stmt->bind_param("ii", $position, $id);
    if (!$stmt->execute()) {
        echo json_encode([
            "success" => false,
            "error" => $stmt->error

        ]);
        exit;
    }
}

echo json_encode(["success" => true]);



?>