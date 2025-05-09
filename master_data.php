<link rel="stylesheet" href="bachelor.css" />
<?php include 'header.php'; ?>

<main>
  <div class="university-container">
    <?php
    $universities = json_decode(file_get_contents("data.json"), true);

    foreach ($universities as $uni) {
      if ($uni['category']['category_id'] === 2) { // Master's
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
        echo "      <button class='wishlist-btn' data-name='{$uni['name']}' data-country='{$uni['country']}' data-image='{$uni['image_url']}'>";
        echo "        <i class='fas fa-heart'></i> Wishlist";
        echo "      </button>";
        echo "    </div>";
        echo "  </div>";
        echo "</div>";
      }
    }
    ?>
  </div>
</main>

<?php include 'footer.php'; ?>
