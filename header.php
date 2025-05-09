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

<div class="wishlist-content" id="wishlistContent">
  <p>Loading wishlist...</p>
</div>

</div>

  <script>
 function toggleWishlist() {
  const panel = document.getElementById("wishlistPanel");
  panel.classList.toggle("open");

  // Fetch updated wishlist when opening
  if (panel.classList.contains("open")) {
    fetch('wishlist_fetch.php')
      .then(res => res.text())
      .then(html => {
        document.getElementById("wishlistContent").innerHTML = html;
      })
      .catch(err => {
        document.getElementById("wishlistContent").innerHTML = "<p>Error loading wishlist.</p>";
        console.error(err);
      });
  }
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

       
      })
      .catch(error => {
        console.error('Error:', error);
        alert('Error adding to wishlist');
      });
    });
  });
});
document.addEventListener("click", function (e) {
  if (e.target.classList.contains("remove-wishlist-btn")) {
    const id = e.target.getAttribute("data-id");

    fetch('remove_from_wishlist.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: `id=${encodeURIComponent(id)}`
    })
    .then(response => response.text())
    .then(data => {
      console.log("Remove response:", data);
      // Reload wishlist
      fetch('wishlist_fetch.php')
        .then(res => res.text())
        .then(html => {
          document.getElementById("wishlistContent").innerHTML = html;
        });
    })
    .catch(err => {
      alert("Failed to remove item");
      console.error(err);
    });
  }
});

</script>
