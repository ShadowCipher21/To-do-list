<?php
include "../db.php";
header('Content-Type: application/json');
$data = json_decode(file_get_contents("php://input"), true);

if (!$data || !isset($data["text"])) {
    echo json_encode(["error" => "No text received"]);
    exit;
}

$text = trim($data["text"]);
$completed = 0;
$priority = 'medium';
$dueDate = null;

if ($text === "") {
    echo json_encode(["error" => "Empty task"]);
    exit;

}
// $sql = "INSERT INTO tasks (text, completed, priority, dueDate)
//         VALUES ('$text', $completed, '$priority', NULL)";
$stmt = $conn->prepare("INSERT INTO  tasks (text, completed, priority, dueDate, position) VALUES(?, ?, ?, NULL, ?)");

$stmt->bind_param("sisi", $text, $completed, $priority, $newPosition);

if($stmt->execute()){
    echo json_encode(["success" => true]);

}else{
    echo json_encode(["error" => $stmt->error]);
}


?>