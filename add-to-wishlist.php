<?php
session_start();
require 'database.php';

header('Content-Type: application/json');

if (!isset($_SESSION["user"])) {
    echo json_encode(["status" => "error", "message" => "You must be logged in."]);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $userId = $_SESSION["user"]["id"];
    $universityName = trim($_POST["university_name"] ?? "");
    $country = trim($_POST["country"] ?? "");
    $imageUrl = trim($_POST["image_url"] ?? "");

    if ($universityName && $country && $imageUrl) {
        // Check if already in DB
        $checkStmt = $conn->prepare("SELECT id FROM wishlist WHERE user_id = ? AND university_name = ?");
        $checkStmt->bind_param("is", $userId, $universityName);
        $checkStmt->execute();
        $checkStmt->store_result();

        if ($checkStmt->num_rows > 0) {
            echo json_encode(["status" => "exists", "message" => "Already in wishlist!"]);
        } else {
            // Insert into DB
            $insertStmt = $conn->prepare("INSERT INTO wishlist (user_id, university_name, country, image_url) VALUES (?, ?, ?, ?)");
            $insertStmt->bind_param("isss", $userId, $universityName, $country, $imageUrl);

            if ($insertStmt->execute()) {
                echo json_encode(["status" => "success", "message" => "University added to wishlist!"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Failed to add to database."]);
            }
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Missing required fields."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
}
?>
