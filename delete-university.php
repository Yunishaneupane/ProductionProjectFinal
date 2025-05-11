<?php
require 'database.php';

if (!isset($_GET['id'])) {
    echo "Invalid request.";
    exit;
}

$universityId = intval($_GET['id']);

$query = "DELETE FROM universities WHERE university_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $universityId);
$stmt->execute();

header("Location: admin-dashboard.php");
exit;
