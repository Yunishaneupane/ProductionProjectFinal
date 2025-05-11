<?php 
session_start();
require 'database.php';

// Optional: Restrict access to admin only
if (!isset($_SESSION["user"]) || $_SESSION["user"]["role"] !== 'admin') {
    echo "Access denied.";
    exit;
}

// Handle search and sorting
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$order = isset($_GET['sort']) && $_GET['sort'] === 'desc' ? 'DESC' : 'ASC';

// Build query
$query = "SELECT university_id, name, country, image_url, ranking FROM universities";
if (!empty($search)) {
    $searchSafe = $conn->real_escape_string($search);
    $query .= " WHERE name LIKE '%$searchSafe%' OR country LIKE '%$searchSafe%'";
}
$query .= " ORDER BY ranking $order";

$result = $conn->query($query);
$total = $result->num_rows;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard - Universities</title>
  <link rel="stylesheet" href="admin-dashboard.css">
</head>
<body>

  <!-- Admin Header -->
  <header class="admin-header">
    <div class="admin-header-container">
    <a href="admin-dashboard.php">  <h2>🎓 EduPath Admin Panel</h2></a>
      <nav>
        <a href="admin-dashboard.php">Dashboard</a>
        <a href="add-university.php">Add University</a>
        <a href="logout.php" onclick="return confirm('Logout now?')">Logout</a>
      </nav>
    </div>
  </header>

<div class="banner-section">
  <div class="banner-content">
    <h1 class="banner-text">All Universities</h1>
    <p class="banner-slogan">Explore, Compare, and Choose the Best for You!</p>
  </div>
</div>


<div class="search-sort-bar">
  <form method="GET" class="search-form">
    <input type="text" name="search" placeholder="Search universities..." value="<?= htmlspecialchars($search) ?>">
    <select name="sort" onchange="this.form.submit()">
      <option value="asc" <?= $order === 'ASC' ? 'selected' : '' ?>>Rank: Low to High</option>
      <option value="desc" <?= $order === 'DESC' ? 'selected' : '' ?>>Rank: High to Low</option>
    </select>
  </form>
  <p class="result-text"><?= $total ?> Results</p>
</div>


  <!-- University Cards -->
  <div class="university-container">
    <?php while ($uni = $result->fetch_assoc()): ?>
      <div class="university-card">
        <img src="<?= htmlspecialchars($uni['image_url']) ?>" alt="<?= htmlspecialchars($uni['name']) ?>">
        <h3><?= htmlspecialchars($uni['name']) ?></h3>
        <p><strong><?= htmlspecialchars($uni['country']) ?></strong></p>
        <div class="admin-actions">
          <a href="edit-university.php?id=<?= $uni['university_id'] ?>">Edit</a> |
          <a href="delete-university.php?id=<?= $uni['university_id'] ?>" onclick="return confirm('Are you sure you want to delete this university?')">Delete</a>
        </div>
      </div>
    <?php endwhile; ?>
  </div>




  <script>
document.addEventListener("DOMContentLoaded", function () {
  const searchInput = document.querySelector('input[name="search"]');
  const sortSelect = document.querySelector('select[name="sort"]');
  const universityContainer = document.querySelector(".university-container");
  const resultText = document.querySelector(".result-text");

  function fetchResults() {
    const search = searchInput.value.trim();
    const sort = sortSelect.value;

    fetch(`fetch-universities.php?search=${encodeURIComponent(search)}&sort=${encodeURIComponent(sort)}`)
      .then(res => res.text())
      .then(data => {
        universityContainer.innerHTML = data;
        resultText.textContent = document.querySelector('#total-count')?.textContent || "0 Results";
      });
  }

  searchInput.addEventListener("keyup", fetchResults);
  sortSelect.addEventListener("change", fetchResults);
});
</script>


</body>
</html>