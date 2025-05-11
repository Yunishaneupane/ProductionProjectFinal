<?php
require 'database.php';
include 'header.php';
?>
<link rel="stylesheet" href="bachelor.css" />

<main>
  <div class="university-container">
    <?php
    // Fetch universities offering Master's programs (category_id = 2)
    $query = "
      SELECT DISTINCT u.university_id, u.name, u.country, u.image_url
      FROM universities u
      JOIN programs p ON u.university_id = p.university_id
      JOIN category c ON p.program_level = c.name
      WHERE c.category_id = 2
    ";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
      while ($uni = $result->fetch_assoc()) {
        echo "<div class='university-card'>";
        echo "  <div class='card-header'>";
        echo "    <img src='{$uni['image_url']}' alt='{$uni['name']} Logo' class='college-img' />";
        echo "    <div class='college-info'>";
        echo "      <h3>{$uni['name']}</h3>";
        echo "      <p><i class='fas fa-map-marker-alt'></i> {$uni['country']}</p>";
        echo "    </div>";
        echo "  </div>";
        echo "  <div class='card-footer'>";
        echo "    <button class='view-btn'>View University</button>";
        echo "    <a class='programs-btn' href='programs.php?id={$uni['university_id']}'>View Programs</a>";
        echo "    <div class='card-actions'>";
        echo "      <button class='contact-btn'><i class='fas fa-envelope'></i> Contact</button>";
        echo "      <button class='wishlist-btn' data-name='{$uni['name']}' data-country='{$uni['country']}' data-image='{$uni['image_url']}'><i class='fas fa-heart'></i> Wishlist</button>";
        echo "    </div>";
        echo "  </div>";
        echo "</div>";
      }
    } else {
      echo "<p style='text-align:center; color:red;'>No universities found offering Master's programs.</p>";
    }
    ?>
  </div>
</main>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const wishlistButtons = document.querySelectorAll('.wishlist-btn');

    wishlistButtons.forEach(button => {
      button.addEventListener('click', function() {
        const universityName = this.getAttribute('data-name');
        const country = this.getAttribute('data-country');
        const imageUrl = this.getAttribute('data-image');

        fetch('add-to-wishlist.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
          },
          body: `university_name=${encodeURIComponent(universityName)}&country=${encodeURIComponent(country)}&image_url=${encodeURIComponent(imageUrl)}`
        })
        .then(response => response.text())
        .then(data => alert(data))
        .catch(error => console.error('Error:', error));
      });
    });
  });
</script>

<?php include 'footer.php'; ?>
