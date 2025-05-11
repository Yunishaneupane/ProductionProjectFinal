<?php
require 'database.php';

header('Content-Type: application/json');

// Fetch study levels from category table
$levels = [];
$levelQuery = "SELECT name FROM category";
$levelResult = $conn->query($levelQuery);
while ($row = $levelResult->fetch_assoc()) {
    $levels[] = $row['name'];
}

// Fetch unique countries from universities table
$countries = [];
$countryQuery = "SELECT DISTINCT country FROM universities";
$countryResult = $conn->query($countryQuery);
while ($row = $countryResult->fetch_assoc()) {
    $countries[] = $row['country'];
}

// Fetch unique countries from universities table
$fields = [];
$fieldQuery = "SELECT DISTINCT program_name FROM programs";
$fieldResult = $conn->query($fieldQuery);
while ($row = $fieldResult->fetch_assoc()) {
    $fields[] = $row['program_name'];
}



// Return both as JSON
echo json_encode([
    'levels' => $levels,
    'countries' => $countries,
    'fields'=>$fields
]);
?>
