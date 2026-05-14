<?php
include "../db.php";
header("Content-Type: application/json");
//$conn = new mysqli("localhost", "root", "", "task_app");
$data = json_decode(file_get_contents("php://input"), true);

// if($conn->connect_error) {
//     echo json_encode(["success" => false, "error" => "DB connection failed"]);
//     exit;
// }
if(!$data || !isset($data["id"]) || !isset($data["completed"])) {
    echo json_encode([
        "success" => false,
        "error" => "Invalid input"
    ]);
    exit;
}

//$data = json_decode(file_get_contents("php://input"), true);


$id = intval($data["id"]);
$completed = intval($data["completed"]);

// if($id === null || $completed === null) {
//     echo json_encode(["success" => false, "error" => "Invalid input"]);
//     exit;
// }

//$sql = "UPDATE tasks SET completed = ? WHERE id = ?";
$stmt = $conn->prepare("Update tasks SET completed = ? WHERE id = ?");
$stmt->bind_param("ii", $completed, $id);


if($stmt->execute()) {
    echo json_encode([
        "success" => true,
        "id" => $id,
        "completed" => $completed
    ]);

}else {
    echo json_encode([
        "success" => false, 
        "error" => $stmt->error
    ]);

}

$stmt->close();
$conn->close();




?>