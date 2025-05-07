<?php
session_start();
require 'database.php'; // your DB connection

if (!isset($_SESSION["user"])) {
    echo "You must be logged in.";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["university_name"], $_POST["country"], $_POST["image_url"])) {
        $userId = $_SESSION["user"]["id"];
        $universityName = $_POST["university_name"];
        $country = $_POST["country"];
        $imageUrl = $_POST["image_url"];

        // Check if already in wishlist (same user_id and university_name)
        $checkStmt = $conn->prepare("SELECT id FROM wishlist WHERE user_id = ? AND university_name = ?");
        $checkStmt->bind_param("is", $userId, $universityName);
        $checkStmt->execute();
        $checkStmt->store_result();

        if ($checkStmt->num_rows > 0) {
            echo "Already in wishlist!";
        } else {
            // Not in wishlist, insert it
            $insertStmt = $conn->prepare("INSERT INTO wishlist (user_id, university_name, country, image_url) VALUES (?, ?, ?, ?)");
            $insertStmt->bind_param("isss", $userId, $universityName, $country, $imageUrl);

            if ($insertStmt->execute()) {
                // Also update the SESSION
                $_SESSION["wishlist"][] = [
                    "name" => $universityName,
                    "country" => $country,
                    "image_url" => $imageUrl
                ];
                echo "University added to wishlist!";
            } else {
                echo "Database insert failed!";
            }
        }
    } else {
        echo "Some fields missing!";
    }
} else {
    echo "Invalid request method.";
}
?>
