<?php
include('config.php');
include('db.php');


$reservations = [];
$sql = "SELECT * FROM $reservationsTable";
$stmt = $mysqli->prepare($sql);


if ($stmt->execute()) {
    
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        // output data of each row
		
        while ($row = $result->fetch_assoc()) {
     
            $reservations[] = array(
                "id" => (int)$row["id"],
                "name" => $row["name"],
                "reservation_date" => $row["reservation_date"],
                "guests" => (int)$row["guests"],
			);
        }
    }
}
echo json_encode($reservations);