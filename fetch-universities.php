<?php
require 'database.php';

$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$order = isset($_GET['sort']) && $_GET['sort'] === 'desc' ? 'DESC' : 'ASC';

$query = "SELECT university_id, name, country, image_url, ranking FROM universities";
if (!empty($search)) {
  $safeSearch = $conn->real_escape_string($search);
  $query .= " WHERE name LIKE '%$safeSearch%' OR country LIKE '%$safeSearch%'";
}
$query .= " ORDER BY ranking $order";

$result = $conn->query($query);
$total = $result->num_rows;

echo "<span id='total-count' style='display:none;'>{$total} Results</span>";

while ($uni = $result->fetch_assoc()) {
  echo '<div class="university-card">';
  echo '<img src="' . htmlspecialchars($uni['image_url']) . '" alt="' . htmlspecialchars($uni['name']) . '">';
  echo '<h3>' . htmlspecialchars($uni['name']) . '</h3>';
  echo '<p><strong>' . htmlspecialchars($uni['country']) . '</strong></p>';
  echo '<div class="admin-actions">';
  echo '<a href="edit-university.php?id=' . $uni['university_id'] . '">Edit</a> | ';
  echo '<a href="delete-university.php?id=' . $uni['university_id'] . '" onclick="return confirm(\'Are you sure you want to delete this university?\')">Delete</a>';
  echo '</div></div>';
}
?>
