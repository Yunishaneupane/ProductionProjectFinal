<?php
session_start();
require 'database.php';

if (!isset($_SESSION["user"])) {
  echo "<p>Please log in to view your wishlist.</p>";
  exit;
}

$userId = $_SESSION["user"]["id"];

$query = "SELECT id, university_name, country, image_url FROM wishlist WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
  while ($item = $result->fetch_assoc()) {
    echo '<div class="wishlist-item">';
    echo '<div class="wishlist-info">';
    echo '<img src="' . htmlspecialchars($item["image_url"]) . '" alt="' . htmlspecialchars($item["university_name"]) . ' Logo" class="wishlist-logo">';
    echo '<h3>' . htmlspecialchars($item["university_name"]) . '</h3>';
    echo '<p><strong>' . htmlspecialchars($item["country"]) . '</strong></p>';
    echo '</div>';

    echo '<div class="wishlist-actions">';
    echo '<button class="remove-wishlist-btn" data-id="' . $item["id"] . '">';
    echo '<i class="fas fa-trash-alt"></i> Remove';
    echo '</button>';
    echo '</div>';
    echo '</div>';

  }
} else {
  echo '<p style="padding: 1rem;color: black;">Your wishlist is empty.</p>';
}
?>
<style>
  .wishlist-item {
  display: flex;
  justify-content: space-between;
  align-items: center;
  border: 1px solid #ddd;
  padding: 15px;
  margin-bottom: 12px;
  border-radius: 8px;
  background-color: #f9f9f9;
}

.wishlist-info {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 15px;
}

.wishlist-info img.wishlist-logo {
  width: 60px;
  height: 60px;
  object-fit: cover;
  border-radius: 8px;
  border: 1px solid #ccc;
}

.wishlist-actions {
  display: flex;
  align-items: center;
}

.remove-wishlist-btn {
  background-color: #ff4d4d;
  border: none;
  color: white;
  padding: 8px 14px;
  border-radius: 6px;
  font-size: 14px;
  cursor: pointer;
  transition: background-color 0.3s ease;
  display: inline-flex;
  align-items: center;
  gap: 8px;
}

.remove-wishlist-btn i {
  font-size: 16px;
}

.remove-wishlist-btn:hover {
  background-color: #e60000;
}

</style>