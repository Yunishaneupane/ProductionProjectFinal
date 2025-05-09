<?php
require 'database.php'; // make sure this sets up $conn as mysqli

// Load and decode the JSON data
$json = file_get_contents('data.json');
$universities = json_decode($json, true);

// Prepare SQL statement
$stmt = $conn->prepare("
  INSERT INTO Universities (university_id, name, country, ranking, description, image_url)
  VALUES (?, ?, ?, ?, ?, ?)
");

// Bind parameters
$stmt->bind_param("ississ", $id, $name, $country, $ranking, $description, $image_url);

// Loop through JSON and insert into database
foreach ($universities as $uni) {
    $id = $uni['university_id'];
    $name = $uni['name'];
    $country = $uni['country'];
    $ranking = $uni['ranking'];
    $description = $uni['details']; // 'details' field maps to DB 'description'
    $image_url = $uni['image_url'];

    if ($stmt->execute()) {
        echo "✅ Inserted: $name<br>";
    } else {
        echo "❌ Failed to insert $name: " . $stmt->error . "<br>";
    }
}

$stmt->close();
$conn->close();
?>
