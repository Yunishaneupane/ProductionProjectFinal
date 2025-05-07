<?php
session_start();
$isLoggedIn = isset($_SESSION["user"]);
$userName = $isLoggedIn ? $_SESSION["user"]["name"] : '';
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>EduPath Header</title>
  <link rel="stylesheet" href="header.css" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>

<body>
  <header class="header">
    <a href="home.php" class="logo-link">
      <div class="logo">Edu<span class="light">Path</span></div>
    </a>

    <nav class="nav-links">
      <div class="dropdown">
        <a href="#">Find Colleges <i class="fa-solid fa-chevron-down dropdown-icon"></i></a>
        <div class="dropdown-content">
          <a href="bachelor.php">For Bachelors</a>
          <a href="masters.php">For Masters</a>
          <a href="phd.php">For PhD</a>
        </div>
      </div>
      <a href="forstudent.php">For Students</a>
      <a href="forinstitution.php">For Institutions</a>
      <a href="aboutus.php">About us</a>
      <a href="contactus.php">Contact us</a>
    </nav>

    <div class="actions">
      <?php if ($isLoggedIn): ?>
        <div class="welcome-msg">👋 Welcome, <?= htmlspecialchars($userName) ?></div>
        <button class="logout-btn" onclick="window.location.href='logout.php'">Logout</button>
      <?php else: ?>
        <button class="login-btn" onclick="window.location.href='login.php'">Login</button>
        <button class="signup-btn" onclick="window.location.href='login.php'">Signup</button>
      <?php endif; ?>

      <div class="wishlist" onclick="toggleWishlist()">
        <i class="fas fa-heart"></i>
      </div>
    </div>
  </header>

  <!-- Wishlist Panel -->
  <div id="wishlistPanel" class="wishlist-panel">
  <div class="wishlist-header">
    <h2>Wishlist</h2>
    <button class="wishlist-close" onclick="toggleWishlist()">✕</button>
  </div>

  <div class="wishlist-content">
    <?php if (!empty($_SESSION["wishlist"])): ?>
      <?php foreach ($_SESSION["wishlist"] as $item): ?>
        <div class="wishlist-item">
          <h3><?= htmlspecialchars($item["name"]) ?></h3>
          <p><strong><?= htmlspecialchars($item["country"]) ?></strong></p>
          <img src="<?= htmlspecialchars($item["image_url"]) ?>" alt="<?= htmlspecialchars($item["name"]) ?> Logo" class="wishlist-logo">
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p style="padding: 1rem;color: black;">Your wishlist is empty.</p>
    <?php endif; ?>
  </div>
</div>

  <script>
    function toggleWishlist() {
      document.getElementById("wishlistPanel").classList.toggle("open");
    }

    window.addEventListener("scroll", () => {
      const header = document.querySelector(".header");
      header.classList.toggle("scrolled", window.scrollY > 0);
    });
  </script>
</body>
</html>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const wishlistButtons = document.querySelectorAll('.wishlist-btn');

  wishlistButtons.forEach(button => {
    button.addEventListener('click', function () {
      const universityName = this.getAttribute('data-name');
      const country = this.getAttribute('data-country');
      const imageUrl = this.getAttribute('data-image');

      fetch('add_to_wishlist.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `university_name=${encodeURIComponent(universityName)}&country=${encodeURIComponent(country)}&image_url=${encodeURIComponent(imageUrl)}`
      })
      .then(response => response.text())
      .then(data => {
        console.log(data); // for debug

        // After successful add, reload the wishlist panel
        fetch('wishlist_fetch.php')
          .then(response => response.text())
          .then(html => {
            document.querySelector('.wishlist-content').innerHTML = html;
          });
      })
      .catch(error => {
        console.error('Error:', error);
        alert('Error adding to wishlist');
      });
    });
  });
});
</script>
