<?php
include('config.php');
include('db.php');

// Check request method
if (!in_array($_SERVER['REQUEST_METHOD'], ['PUT', 'PATCH'])) {
    echo json_encode(["Status" => "ERROR", "Message" => "Invalid request method"]);
    exit;
}
$input = file_get_contents("php://input");
$data = json_decode($input, true);

if (!isset($data['id'], $data['name'], $data['reservation_date'], $data['guests'])) {
    echo json_encode(array("Status" => "ERROR", "Message" => "Missing parameters"));
    exit();
}

$id = $data['id'];

$name = strip_tags($data['name']);
$name = $mysqli->real_escape_string($name);

$reservationDate = $data['reservation_date'];
$parsed = date_parse($reservationDate);

$guests = $data['guests'];

// checks
if (!filter_var($id, FILTER_VALIDATE_INT)) {
    echo json_encode(["Status" => "ERROR", "Message" => "Invalid ID"]);
    exit;
}

if (!filter_var($guests, FILTER_VALIDATE_INT)) {
    echo json_encode(["Status" => "ERROR", "Message" => "Invalid guests number"]);
    exit;
}

if ($parsed['error_count'] > 0 || $parsed['warning_count'] > 0) {
    echo json_encode(["Status" => "ERROR", "Message" => "Invalid date/time"]);
    exit;
}

$reserDate = new DateTime($reservationDate);
$now   = new DateTime();

if ($reserDate < $now) {
    echo json_encode(["Status" => "ERROR", "Message" => "Date error"]);
    exit;
}


// update
// Prepared statement
$sql = "UPDATE $reservationsTable 
            SET name = ?, reservation_date = ?, guests = ? 
            WHERE id = ?";
$stmt = $mysqli->prepare($sql);

if (!$stmt) {
    echo json_encode(["Status" => "ERROR", "Message" => "Prepare failed"]);
    exit;
}

// Bind input id to SQL statement parameter
$stmt->bind_param("ssii", $name, $reservationDate, $guests, $id);

// check if inserted

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo json_encode(array("Status" => "OK", "Message" => "Successfully updated"));
    } else {
        echo json_encode(array("Status" => "OK", "Message" => "No rows affected"));
    }
} else {
    echo json_encode(array("Status" => "ERROR", "Message" => "Execution failed"));
}
