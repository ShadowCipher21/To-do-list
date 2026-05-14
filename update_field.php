<?php
include "../db.php";
header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);

if(!$data || !isset($data["id"]) || !isset($data["field"]) || !isset($data["value"])) {
    echo json_encode([
        "success" => false,
        "error" => "Invalid input"
    ]);
    exit;
}

$id = intval($data["id"]);
$field = $data["field"];
$value = $data["value"] ?? null;

$allowed = ["priority", "dueDate"];

if(!in_array($field, $allowed)) {
    echo json_encode([
        "success" => false,
        "error" => "Invalid field"
    ]);
    exit;

}

$sql = "UPDATE tasks SET $field = ? WHERE id = ?";
$stmt = $conn->prepare($sql);

if($value === "" || $value === null) {
    //$stmt->bind_param("si", $value, $id);
    $value = null;
}
$stmt->bind_param("si", $value, $id);
// else{
//     $stmt->bind_param("si, $value, $id");

// }

if($stmt->execute()) {
    echo json_encode(["success" => true]);

}else{
    echo json_encode([
        "success" => false,
        "error" => $stmt->error
    ]);
}

$stmt->close();
$conn->close();






?>