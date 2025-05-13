    <?php
    session_start();
    require '../database.php';

    if (!isset($_SESSION["university_id"])) {
    header("Location: ../login.php");
    exit;
    }

    $universityId = $_SESSION["university_id"];
    $success = "";
    $error = "";

    // Handle update
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $country = trim($_POST['country']);
    $description = trim($_POST['description']);

    if ($name && $country && $description) {
        $stmt = $conn->prepare("UPDATE universities SET name = ?, country = ?, description = ? WHERE university_id = ?");
        $stmt->bind_param("sssi", $name, $country, $description, $universityId);
        if ($stmt->execute()) {
        $success = "✅ Profile updated successfully!";
        } else {
        $error = "❌ Update failed: " . $stmt->error;
        }
    } else {
        $error = "❗ All fields are required.";
    }
    }

    // Fetch current data
    $stmt = $conn->prepare("SELECT name, country, description FROM universities WHERE university_id = ?");
    $stmt->bind_param("i", $universityId);
    $stmt->execute();
    $result = $stmt->get_result();
    $university = $result->fetch_assoc();
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
    <meta charset="UTF-8">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="../admin-dashboard.css">
    <style>
        .form-container {
        max-width: 600px;
        margin: 3rem auto;
        background: #fff;
        padding: 2rem;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .form-container input,
        .form-container textarea {
        width: 100%;
        padding: 10px;
        margin-bottom: 1rem;
        border: 1px solid #ccc;
        border-radius: 4px;
        }
        .form-container button {
        padding: 10px 20px;
        background-color: #0073e6;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        }
        .success-message, .error-message {
        text-align: center;
        font-weight: bold;
        margin-bottom: 1rem;
        }
        .success-message { color: green; }
        .error-message { color: red; }
    </style>
    </head>
    <body>
    <div class="form-container">
        <h2>Edit Profile</h2>

        <?php if ($success): ?><p class="success-message"><?= $success ?></p><?php endif; ?>
        <?php if ($error): ?><p class="error-message"><?= $error ?></p><?php endif; ?>

        <form method="POST">
        <label for="name">University Name:</label>
        <input type="text" id="name" name="name" value="<?= htmlspecialchars($university['name']) ?>" required>

        <label for="country">Country:</label>
        <input type="text" id="country" name="country" value="<?= htmlspecialchars($university['country']) ?>" required>

        <label for="description">Description:</label>
        <textarea id="description" name="description" rows="5" required><?= htmlspecialchars($university['description']) ?></textarea>

        <button type="submit">Update Profile</button>
     <a href="index.php" style="
  display: inline-block;
  margin-top: 1rem;
  text-align: center;
  background: #444;
  color: white;
padding:6px;
  text-decoration: none;
  border-radius: 4px;
">← Back to Dashboard</a>

        </form>
    </div>
    </body>
    </html>
