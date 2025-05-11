<?php
session_start();
require 'database.php';

// Check if the user is logged in
$isLoggedIn = isset($_SESSION['user']);

// Fetch all universities from the database
$university = null;

$stmt = $conn->prepare("SELECT * FROM universities");
$stmt->execute();
$result = $stmt->get_result();

// Check if universities exist
if ($result->num_rows > 0) {
    $universities = [];
    while ($row = $result->fetch_assoc()) {
        $universities[] = $row;
    }
} else {
    die("Error: No universities found.");
}

$stmt->close();
?>

<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
} 
$recommendations = [];
$error = "";
$transcriptUploaded = false;


// Handle transcript upload
  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['transcript']) && $_FILES['transcript']['error'] === UPLOAD_ERR_OK) {
      $uploadDir = "uploads/";
      if (!is_dir($uploadDir)) mkdir($uploadDir);

      $fileName = "transcript_" . time() . "_" . basename($_FILES["transcript"]["name"]);
      $targetFile = $uploadDir . $fileName;

      if (move_uploaded_file($_FILES["transcript"]["tmp_name"], $targetFile)) {
          // Simulate extraction
          $_SESSION['cgpa'] = 3.5;
          $_SESSION['major'] = "Computer Science";
          $_SESSION['transcript_uploaded'] = true;

          header("Location: " . $_SERVER['PHP_SELF']);
          exit;
      } else {
          $error = "❌ Failed to upload transcript.";
      }
  }

// ✅ Now process recommendations *after redirect* (this should come after the upload block)
if (isset($_SESSION['transcript_uploaded'], $_SESSION['cgpa'], $_SESSION['major'])) {
  $transcriptUploaded = true; // ✅ Set this flag
  $cgpa = $_SESSION['cgpa'];
  $major = $_SESSION['major'];

  $universityData = json_decode(file_get_contents("data.json"), true);
  foreach ($universityData as $uni) {
      if (isset($uni['min_cgpa'], $uni['majors']) && $cgpa >= $uni['min_cgpa'] && in_array($major, $uni['majors'])) {
          $recommendations[] = $uni;
      }
  }

  unset($_SESSION['transcript_uploaded'], $_SESSION['cgpa'], $_SESSION['major']);
}

?>



<?php 
 
include 'header.php'; 
?>




<!-- ---------------------------------- -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Universities</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<style>
    /* === Transcript Upload Section === */
.transcript-upload-section {
  background-color: #f9f9f9;
  padding: 4rem 2rem;
  text-align: center;
  border-radius: 8px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  margin: 4rem auto;
  max-width: 800px;
}

.transcript-upload-section h2 {
  font-size: 2.5rem;
  font-weight: 700;
  color: #333;
  margin-bottom: 1.5rem;
}

.transcript-upload-section p {
  font-size: 1.1rem;
  color: #666;
  margin-bottom: 2rem;
}

.transcript-form {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 1.5rem;
  background-color: white;
  padding: 2rem 2.5rem;
  border-radius: 10px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.transcript-form input[type="file"] {
  padding: 1rem;
  border: 1px solid #ccc;
  border-radius: 6px;
  font-size: 1rem;
  width: 100%;
  max-width: 400px;
  background-color: #fafafa;
  margin-bottom: 1rem;
}

.transcript-form span#file-name {
  font-size: 0.95rem;
  color: #777;
  margin-bottom: 1rem;
  display: block;
}

.transcript-form button {
  padding: 1rem 2rem;
  background-color: #6b0f0f;
  color: #fff;
  font-size: 1.1rem;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.transcript-form button:hover {
  background-color: #874848;
}

.transcript-form button:focus {
  outline: none;
}

.transcript-form button[type="submit"]:disabled {
  background-color: #ccc;
  cursor: not-allowed;
}

/* Mobile responsiveness */
@media (max-width: 768px) {
  .transcript-upload-section {
    padding: 3rem 1.5rem;
    margin: 3rem auto;
  }

  .transcript-form {
    width: 100%;
    padding: 2rem;
  }

  .transcript-form input[type="file"],
  .transcript-form button {
    max-width: 100%;
  }
}

</style>


<section class="transcript-upload-section">
  <h2>Get Personalized University Recommendations</h2>
  <p>Upload your academic transcript and we'll suggest universities that match your profile.</p>

  <form method="POST" enctype="multipart/form-data" class="transcript-form">
    <input type="file" id="transcript" name="transcript" accept=".pdf,.jpg,.png" required>
    <span id="file-name">No file selected</span>
    <button type="submit" name="analyze">Upload Transcript</button>
  </form>

  <?php if (!empty($error)) echo "<p style='color:red; text-align:center;'>$error</p>"; ?>
</section>

<!-- ---------------------------------- -->
<?php if ($transcriptUploaded && !empty($recommendations)): ?>
  <section class="recommended-universities" style="margin-top: 2rem; text-align:center;">
    <h3 style="color:black;">🎓 Recommended Universities Based on Your Transcript</h3>
    <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 1.5rem; padding: 1rem;">
      <?php foreach ($recommendations as $uni): ?>
        <div style="background: #f9f9f9; border: 1px solid #ccc; border-radius: 10px; padding: 1rem; width: 300px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); transition: 0.3s; color: black;">
          <img src="<?= htmlspecialchars($uni['image_url']) ?>" alt="<?= htmlspecialchars($uni['name']) ?>" style="width: 100%; height: 160px; object-fit: cover; border-radius: 10px 10px 0 0;">
          <h4 style="color:#000000; margin-top:10px;"><?= htmlspecialchars($uni['name']) ?></h4>
          <p><strong>Country:</strong> <?= htmlspecialchars($uni['country']) ?></p>
          <p><strong>Min CGPA:</strong> <?= $uni['min_cgpa'] ?></p>
          <p><strong>Majors:</strong> <?= implode(', ', $uni['majors']) ?></p>
          <a class="programs-btn" href="programs.php?id=<?= $uni['university_id'] ?>">View Programs</a>

         </div>
      <?php endforeach; ?>
    </div>
  </section>
<?php elseif ($transcriptUploaded && empty($recommendations)): ?>
  <p style="text-align: center; color: #b00; margin-top: 1rem;">❌ No matching universities found for your transcript.</p>
<?php endif; ?>
<section class="universities-info">
    <h1>Universities</h1>
    <div class="universities-list">
        
        <?php foreach ($universities as $university): ?>
            <div class="university-card">
                <h2><?php echo htmlspecialchars($university['name']); ?></h2>
                <p><strong>Country:</strong> <?php echo htmlspecialchars($university['country']); ?></p>
                <img src="<?php echo htmlspecialchars($university['image_url']); ?>" alt="<?php echo htmlspecialchars($university['name']); ?>" style="max-width: 100%; height: auto; border-radius: 10px;">
                
                <?php if ($isLoggedIn): ?>
                    <!-- If the user is logged in, show the description and apply button -->
                    <h3>Description:</h3>
                    <p><?php echo nl2br(htmlspecialchars($university['description'])); ?></p>
                   
                <?php else: ?>
                    <!-- If the user is not logged in, show the "See More" button -->

                <?php endif; ?>
                
                <!-- "See More" button always visible for non-logged in users -->
                
            </div>
        <?php endforeach; ?>
    </div>
    
</section>

<?php include 'footer.php'; ?>

</body>
</html>
<script>
    document.addEventListener("DOMContentLoaded", () => {
  const transcriptInput = document.getElementById("transcript");
  const fileNameSpan = document.getElementById("file-name");

  if (transcriptInput) {
    transcriptInput.addEventListener("change", () => {
      const file = transcriptInput.files[0];
      fileNameSpan.textContent = file ? file.name : "No file selected";
    });
  }
});
</script>