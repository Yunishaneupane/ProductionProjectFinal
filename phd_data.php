<link rel="stylesheet" href="bachelor.css" />
<?php include 'header.php'; ?>

<div class="university-grid"> <!-- Grid wrapper start -->
<?php
$universities = json_decode(file_get_contents("data.json"), true);

foreach ($universities as $uni) {
  if ($uni['category']['category_id'] === 3) { // PhD's

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
    echo "<a class='programs-btn' href='programs.php?id={$uni['university_id']}'>View Programs</a>";
    echo "    <div class='card-actions'>";
    echo "      <button class='contact-btn'><i class='fas fa-envelope'></i> Contact</button>";
     echo "     <button class='wishlist-btn'data-name='{$uni['name']}'data-country='{$uni['country']}' data-image='{$uni['image_url']}'<i class='fas fa-heart'></i> Wishlist
    </button>
    ";    echo "    </div>";
    echo "  </div>";
    
    echo "</div>";
  }
}
?>
</div> <!-- Grid wrapper end -->
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
<?php include 'footer.php'; ?>
