<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require 'database.php';

// Get university ID from URL
$universityId = isset($_GET['id']) ? intval($_GET['id']) : 0;
if (!$universityId) {
    echo "<h2 style='text-align:center; padding: 3rem;'>Invalid university ID.</h2>";
    exit;
}

// Fetch university with category info using JOIN
// Fetch university info
$stmt = $conn->prepare("SELECT * FROM universities WHERE university_id = ?");
$stmt->bind_param("i", $universityId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<h2 style='text-align:center; padding: 3rem;'>University not found.</h2>";
    exit;
}

$selectedUniversity = $result->fetch_assoc();
$stmt->close();

// Parse category_id string into array
$categoryIds = array_filter(array_map('intval', explode(',', $selectedUniversity['category_id'] ?? '')));

// Fetch all matching categories
$categories = [];
if (!empty($categoryIds)) {
    $placeholders = implode(',', array_fill(0, count($categoryIds), '?'));
    $catStmt = $conn->prepare("SELECT * FROM category WHERE category_id IN ($placeholders)");
    $catStmt->bind_param(str_repeat('i', count($categoryIds)), ...$categoryIds);
    $catStmt->execute();
    $catResult = $catStmt->get_result();
    $categories = $catResult->fetch_all(MYSQLI_ASSOC);
    $catStmt->close();
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title><?php echo $selectedUniversity['name']; ?> - Programs</title>
  <link rel="stylesheet" href="bachelor.css">
  <style>
    .program-hero {
      background: url("images/finduni.jpg") center/cover no-repeat;
      position: relative;
      color: white;
      padding: 100px 20px 80px;
      text-align: center;
    }

    .program-hero::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-color: rgba(0, 0, 0, 0.5);
      z-index: 0;
    }

    .program-hero h1,
    .program-hero p {
      position: relative;
      z-index: 1;
    }

    .uni-details {
      max-width: 800px;
      background: #fff;
      margin: -60px auto 2rem;
      padding: 2rem;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      text-align: center;
      position: relative;
      z-index: 1;
    }

    .uni-details img {
      max-width: 150px;
      border-radius: 10px;
      margin-bottom: 1rem;
    }

    .program-category {
      background-color: #f9f9f9;
      padding: 2rem;
      text-align: center;
    }

    .program-category h2 {
      font-size: 2rem;
      margin-bottom: 1rem;
    }

    .back-btn {
      display: inline-block;
      margin: 2rem auto 0;
      padding: 10px 20px;
      background-color: #004080;
      color: #fff;
      border: none;
      border-radius: 5px;
      text-decoration: none;
      font-weight: 600;
      transition: background-color 0.3s ease;
    }

    .back-btn:hover {
      background-color: #002b5e;
    }

    .category-card {
      max-width: 600px;
      margin: 0 auto;
      background: #ffffff;
      padding: 2rem;
      border-radius: 12px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease;
    }

    .category-card:hover {
      transform: translateY(-4px);
    }

    .category-card h2 {
      color: #004080;
      font-size: 1.8rem;
      margin-bottom: 1rem;
    }

    .category-card h3 {
      font-size: 1.3rem;
      color: #222;
      margin-bottom: 0.5rem;
    }

    .category-card p {
      font-size: 1rem;
      color: #444;
      line-height: 1.5;
    }
  </style>
</head>

<body>

  <?php include 'header.php'; ?>

  <section class="program-hero">
  <h1><?= htmlspecialchars($selectedUniversity['name']) ?></h1>
  <p>Explore program offerings and details</p>
</section>

<div class="uni-details">
  <img src="<?= htmlspecialchars($selectedUniversity['image_url']) ?>" alt="Logo">
  <h2><?= htmlspecialchars($selectedUniversity['name']) ?></h2>
  <p><strong>Country:</strong> <?= htmlspecialchars($selectedUniversity['country']) ?> |
     <strong>Ranking:</strong> #<?= htmlspecialchars($selectedUniversity['ranking']) ?>
  </p>
  <p style="margin-top: 1rem;"><?= nl2br(htmlspecialchars($selectedUniversity['description'])) ?></p>
</div>

<section class="program-category">
  <div class="category-card">
    <h2>Program Categories</h2>
    <?php if (!empty($categories)): ?>
      <?php foreach ($categories as $cat): ?>
        <h3><?= htmlspecialchars($cat['name']) ?></h3>
        <p><?= htmlspecialchars($cat['description']) ?></p>
        <hr style="margin: 1rem 0;">
      <?php endforeach; ?>
    <?php else: ?>
      <p>No categories assigned to this university.</p>
    <?php endif; ?>
  </div>
</section>


<div style="text-align:center;">
  <a class="back-btn" href="javascript:history.back()">← Back</a>
</div>


  <?php include 'footer.php'; ?>
</body>

</html>