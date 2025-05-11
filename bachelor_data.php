<?php
require 'database.php';

$selectedDestination = $_GET['destination'] ?? '';
$selectedSubject = $_GET['subject'] ?? '';
$selectedLevel = $_GET['level'] ?? '';

// Sanitize
$destination = strtolower(trim($selectedDestination));
$subject = strtolower(trim($selectedSubject));
$level = trim($selectedLevel);

// Fetch from database with strict match between program_level and selectedLevel
$stmt = $conn->prepare("
  SELECT u.university_id, u.name, u.country, u.image_url
  FROM universities u
  INNER JOIN programs p ON u.university_id = p.university_id
  WHERE LOWER(u.country) = ?
    AND LOWER(p.program_name) LIKE ?
    AND p.program_level = ?
  GROUP BY u.university_id
");

$searchTerm = "%{$subject}%";
$stmt->bind_param("sss", $destination, $searchTerm, $level);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Matching Universities</title>
  <link rel="stylesheet" href="bachelor.css">
</head>
<body>

<?php include 'header.php'; ?>

<h2 style="text-align:center; margin-top:20px;">
  Universities offering <em><?= htmlspecialchars($selectedSubject) ?></em> in <em><?= htmlspecialchars($selectedDestination) ?></em> (<?= htmlspecialchars($selectedLevel) ?>)
</h2>

<div class="university-container">
<?php
$found = false;
while ($uni = $result->fetch_assoc()):
  $found = true;
?>
  <div class="university-card">
    <div class="card-header">
      <img src="<?= $uni['image_url'] ?>" alt="<?= htmlspecialchars($uni['name']) ?> Logo" class="college-img">
      <div class="college-info">
        <h3><?= htmlspecialchars($uni['name']) ?></h3>
        <p><i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($uni['country']) ?></p>
      </div>
    </div>
    <div class="card-footer">
      <button class="view-btn">View University</button>
      <a class="programs-btn" href="programs.php?id=<?= $uni['university_id'] ?>">View Programs</a>
      <div class="card-actions">
        <button class="contact-btn"><i class="fas fa-envelope"></i> Contact</button>
        <button class="wishlist-btn"
                data-name="<?= htmlspecialchars($uni['name']) ?>"
                data-country="<?= htmlspecialchars($uni['country']) ?>"
                data-image="<?= $uni['image_url'] ?>">
          <i class="fas fa-heart"></i> Wishlist
        </button>
      </div>
    </div>
  </div>
<?php endwhile; ?>
</div>

<?php if (!$found): ?>
  <p style="text-align:center; color:red; margin-top:20px;">
    ❌ No universities found matching your criteria.
  </p>
<?php endif; ?>

<?php include 'footer.php'; ?>

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

</body>
</html>
