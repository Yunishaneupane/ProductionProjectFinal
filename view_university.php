<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require 'database.php';
require 'vendor/autoload.php'; // Load PDF parser
use Smalot\PdfParser\Parser;

$isLoggedIn = isset($_SESSION['user']);



$recommendations = [];
$error = "";
$transcriptUploaded = false;

// Fetch all universities (for regular listing)
$universities = [];
$universityStmt = $conn->prepare("SELECT * FROM universities");
$universityStmt->execute();
$universityResult = $universityStmt->get_result();
if ($universityResult->num_rows > 0) {
    while ($row = $universityResult->fetch_assoc()) {
        $universities[] = $row;
    }
}
$universityStmt->close();

// ✅ Handle Transcript Upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['transcript']) && $_FILES['transcript']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = "uploads/";
    if (!is_dir($uploadDir)) mkdir($uploadDir);

    $fileName = "transcript_" . time() . "_" . basename($_FILES["transcript"]["name"]);
    $targetFile = $uploadDir . $fileName;

    if (move_uploaded_file($_FILES["transcript"]["tmp_name"], $targetFile)) {
        $parser = new Parser();
        $pdf = $parser->parseFile($targetFile);
        $text = $pdf->getText();

        $cgpaExtracted = null;

        // ✅ Match CGPA or Cumulative GPA (case-insensitive)
        if (preg_match('/(Cumulative GPA|CGPA)\s*[:=]?\s*([0-9]+(?:\.[0-9]+)?)/i', $text, $matches)) {
            $cgpaExtracted = (float)$matches[2];
        }

        $_SESSION['transcript_uploaded'] = true;

        if ($cgpaExtracted === null) {
            $error = "❌ Invalid PDF: CGPA not found.";
        } else {
            $_SESSION['cgpa'] = $cgpaExtracted;
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        }
    } else {
        $error = "❌ Failed to upload transcript.";
    }
}

// ✅ After Redirect: Filter Recommendations
if (isset($_SESSION['transcript_uploaded'], $_SESSION['cgpa'])) {
    $transcriptUploaded = true;
    $cgpa = $_SESSION['cgpa'];

    $stmt = $conn->prepare("SELECT * FROM universities WHERE min_cgpa <= ?");
    $stmt->bind_param("d", $cgpa);
    $stmt->execute();
    $result = $stmt->get_result();
    $recommendations = $result->fetch_all(MYSQLI_ASSOC);

    unset($_SESSION['transcript_uploaded'], $_SESSION['cgpa']);
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

 <?php if ($isLoggedIn): ?>
  <form method="POST" enctype="multipart/form-data" class="transcript-form">
    <input type="file" id="transcript" name="transcript" accept=".pdf,.jpg,.png" required>
    <span id="file-name">No file selected</span>
    <button type="submit" name="analyze">Upload Transcript</button>
  </form>
<?php else: ?>
  <p style="color: red; font-weight: bold; font-size: 1.1rem;">
    Please <a href="login.php">log in</a> to upload your transcript and receive personalized recommendations.
  </p>
<?php endif; ?>


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
          <p><strong>Min CGPA Required:</strong> <?= htmlspecialchars($uni['min_cgpa']) ?></p>
          <a class="programs-btn" href="programs.php?id=<?= urlencode($uni['university_id']) ?>" style="display: inline-block; margin-top: 10px; padding: 8px 12px; background-color: #007bff; color: #fff; border-radius: 5px; text-decoration: none;">View Programs</a>
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