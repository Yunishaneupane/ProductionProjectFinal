<?php
require 'database.php';

$response = [
  "levels" => [],
  "countries" => [],
  "fields" => []
];

// Study levels from category table
$levelResult = $conn->query("SELECT DISTINCT name FROM category");
while ($row = $levelResult->fetch_assoc()) {
  $response['levels'][] = $row['name'];
}

// Countries from universities table
$countryResult = $conn->query("SELECT DISTINCT country FROM universities");
while ($row = $countryResult->fetch_assoc()) {
  $response['countries'][] = $row['country'];
}

// Subjects (programs) from programs table
$fieldResult = $conn->query("SELECT DISTINCT program_name FROM programs");
while ($row = $fieldResult->fetch_assoc()) {
  $response['fields'][] = $row['program_name'];
}

header('Content-Type: application/json');
echo json_encode($response);
?>
