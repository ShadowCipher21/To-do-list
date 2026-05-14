<?php
include "../db.php";

$sql = "SELECT * FROM tasks ORDER BY position ASC, id ASC";

$result = $conn->query($sql);
$tasks = [];

if($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $tasks[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($tasks);

?>