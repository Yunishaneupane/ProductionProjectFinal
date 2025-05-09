<?php
session_start();
require 'database.php';

if (!isset($_SESSION["user"])) {
    http_response_code(401);
    echo "Unauthorized";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $userId = $_SESSION["user"]["id"];
    $wishlistId = intval($_POST["id"]);

    $stmt = $conn->prepare("DELETE FROM wishlist WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $wishlistId, $userId);

    if ($stmt->execute()) {
        echo "Deleted";
    } else {
        http_response_code(500);
        echo "Error deleting item";
    }
} else {
    http_response_code(405);
    echo "Invalid request";
}
?>
