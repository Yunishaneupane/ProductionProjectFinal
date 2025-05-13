<?php
require 'database.php';

$country = $_GET['country'] ?? '';
$level = $_GET['level'] ?? '';

$stmt = $conn->prepare("
  SELECT DISTINCT u.name, u.image_url, u.country, u.description
  FROM universities u
  JOIN programs p ON u.university_id = p.university_id
  JOIN university_category uc ON u.university_id = uc.university_id
  JOIN category c ON uc.category_id = c.category_id
  WHERE u.country = ? AND c.name = ?
");
$stmt->bind_param("ss", $country, $level);
$stmt->execute();
$result = $stmt->get_result();

$universities = [];
while ($row = $result->fetch_assoc()) {
  $universities[] = $row;
}

header('Content-Type: application/json');
echo json_encode($universities);
?>
