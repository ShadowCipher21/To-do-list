<?php
include "../db.php";
header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);

if(!$data || !isset($data["id"]) || !isset($data["text"])) {
    echo json_encode([
        "success" => false,
        "error" => "Invalid input"

    ]);
    exit;
}

$id = intval($data["id"]);
$text = trim($data["text"]);

if($text === ""){
    echo json_encode([
        "success" => false,
        "error" => "Empty text"
    ]);

    exit;
}
$stmt = $conn->prepare("UPDATE tasks SET text = ? WHERE id = ?");
$stmt->bind_param("si", $text, $id);

if($stmt->execute()){
    echo json_encode([
        "success" => true
    ]);

}else{
    echo json_encode([
        "success" => false,
        "error" => $stmt->error
    ]);
}
$stmt->close();
$conn->close();


?>