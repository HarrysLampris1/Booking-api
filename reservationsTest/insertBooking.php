<?php
include('config.php');
include('db.php');

if (!in_array($_SERVER['REQUEST_METHOD'], ['POST'])) {
    echo json_encode(["Status" => "ERROR", "Message" => "Invalid request method"]);
    exit;
}

$input = file_get_contents("php://input");
$data = json_decode($input, true);

if (!isset($data['name'], $data['reservation_date'], $data['guests'])) {
    echo json_encode(array("Status" => "ERROR", "Message" => "VARIABLE NOT SET PROPERLY"));
    exit;
}


$name = strip_tags($data['name']);
$name = $mysqli->real_escape_string($name);

$reservationDate = $data['reservation_date'];
$parsed = date_parse($reservationDate);

$guests = $data['guests'];

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



$sql = "INSERT INTO $reservationsTable (name, reservation_date, guests) VALUES (?, ?, ?)";
$stmt = $mysqli->prepare($sql);

if (!$stmt) {
    echo json_encode(["Status" => "ERROR", "Message" => "Prepare failed"]);
    exit;
}

// Bind input id to SQL statement parameter
$stmt->bind_param("ssi", $name, $reservationDate, $guests);

if ($stmt->execute()) {
    echo json_encode(["Status" => "OK", "Message" => "Successfully inserted", "reservation_id" => $stmt->insert_id]);
} else {
    echo json_encode(["Status" => "ERROR", "Message" => "Execution failed"]);
}

