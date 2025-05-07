<link rel="stylesheet" href="bachelor.css" />
<?php include 'header.php'; ?>

<?php
// Load universities
$universities = json_decode(file_get_contents("data.json"), true);

// Get selected destination and subject from URL
$selectedDestination = isset($_GET['destination']) ? $_GET['destination'] : "";
$selectedSubject = isset($_GET['subject']) ? $_GET['subject'] : "";

$found = false; // Track if any match found

foreach ($universities as $uni) {
  if ($uni['category']['category_id'] === 1) { // Bachelor's
    if (
      strtolower($uni['country']) === strtolower($selectedDestination)
      // You can also later match subject if you add subject info inside each university
    ) {
      $found = true;
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
      echo "    <button class='programs-btn'>View Programs</button>";
      echo "    <div class='card-actions'>";
      echo "      <button class='contact-btn'><i class='fas fa-envelope'></i> Contact</button>";
      echo "     <button class='wishlist-btn'data-name='{$uni['name']}'data-country='{$uni['country']}' data-image='{$uni['image_url']}'<i class='fas fa-heart'></i> Wishlist
    </button>
    ";
          echo "    </div>";
      echo "  </div>";
      echo "</div>";
    }
  }
}

if (!$found) {
  echo "<p style='text-align:center; color:red; margin-top:20px;'>❌ No universities found matching your criteria.</p>";
}
?>

<?php include 'footer.php'; ?>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const wishlistButtons = document.querySelectorAll('.wishlist-btn');

    wishlistButtons.forEach(button => {
      button.addEventListener('click', function() {
        const universityName = this.getAttribute('data-name');
        const country = this.getAttribute('data-country');
        const imageUrl = this.getAttribute('data-image');

        // Send the university info via AJAX
        fetch('add-to-wishlist.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `university_name=${encodeURIComponent(universityName)}&country=${encodeURIComponent(country)}&image_url=${encodeURIComponent(imageUrl)}`
          })
          .then(response => response.text())
          .then(data => {
            alert(data);
          })
          .catch(error => {
            console.error('Error:', error);
          });
      });
    });
  });
</script>