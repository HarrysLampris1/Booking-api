<?php
include('config.php');
include('db.php');

// Check if request method is DELETE
if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
    echo json_encode(array("Status" => "ERROR", "Message" => "Invalid request method"));
    exit;
}

// Get input data from POST body
$input = file_get_contents("php://input");
$data = json_decode($input, true);


if (!isset($data['id'])) {
    echo json_encode(array("Status" => "ERROR", "Message" => "Missing parameters"));
    exit;
}


$id = $data['id'];


if (!filter_var($id, FILTER_VALIDATE_INT)) {
    echo json_encode(array("Status" => "ERROR", "Message" => "Invalid parameters"));
    exit;
}


$sql = "DELETE FROM $reservationsTable WHERE id = ?";
$stmt = $mysqli->prepare($sql);

if ($stmt === false) {
    echo json_encode(array("Status" => "ERROR", "Message" => "Prepare failed"));
    exit;
}

// Bind input id to SQL statement parameter
$stmt->bind_param("i", $id);

// Execute SQL statement and check if execution succeeded
if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo json_encode(array("Status" => "OK", "Message" => "Successfully deleted"));
    } else {
        echo json_encode(array("Status" => "OK", "Message" => "No record found"));
    }
} else {
    echo json_encode(array("Status" => "ERROR", "Message" => "Execution failed"));
}

$stmt->close();
