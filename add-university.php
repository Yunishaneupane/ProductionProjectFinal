<?php
session_start();
require 'database.php';

// Restrict access to admin only
if (!isset($_SESSION["user"]) || $_SESSION["user"]["role"] !== 'admin') {
    echo "Access denied.";
    exit;
}

$success = "";
$error = "";

// Fetch all categories for the dropdown
$catResult = $conn->query("SELECT * FROM category");
$allCategories = [];
while ($row = $catResult->fetch_assoc()) {
    $allCategories[] = $row;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $country = trim($_POST['country']);
    $imageUrl = trim($_POST['image_url']);
    $ranking = isset($_POST['ranking']) ? intval($_POST['ranking']) : null;
    $description = isset($_POST['description']) ? trim($_POST['description']) : '';
    $categoryIds = isset($_POST['category_ids']) ? implode(',', $_POST['category_ids']) : '';

    if ($name && $country && $imageUrl && $description) {
        $query = "INSERT INTO universities (name, country, image_url, ranking, description, category_id) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);

        if (!$stmt) {
            $error = "❌ Prepare failed: " . $conn->error;
        } else {
            $stmt->bind_param("sssiss", $name, $country, $imageUrl, $ranking, $description, $categoryIds);

            if ($stmt->execute()) {
                $university_id = $conn->insert_id;

                // Insert programs
                if (!empty($_POST['programs'])) {
                    $programs = $_POST['programs'];
                    $levels = $_POST['levels'];
                    $durations = $_POST['durations'];
                    $fees = $_POST['fees'];

                    for ($i = 0; $i < count($programs); $i++) {
                        $pname = trim($programs[$i]);
                        $plevel = trim($levels[$i]);
                        $pduration = intval($durations[$i]);
                        $pfee = floatval($fees[$i]);

                        $prog_stmt = $conn->prepare("INSERT INTO programs (university_id, program_name, program_level, duration_years, tuition_fee) VALUES (?, ?, ?, ?, ?)");
                        if ($prog_stmt) {
                            $prog_stmt->bind_param("issid", $university_id, $pname, $plevel, $pduration, $pfee);
                            $prog_stmt->execute();
                        }
                    }
                }

                $success = "✅ University and programs added successfully!";
            } else {
                $error = "❌ Failed to add university: " . $stmt->error;
            }
        }
    } else {
        $error = "❗ All fields except ranking are required.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Add New University</title>
    <link rel="stylesheet" href="admin-dashboard.css">
    <style>
        .program-block {
            margin-bottom: 15px;
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 5px;
        }
        .program-block input {
            display: block;
            margin-bottom: 8px;
            width: 100%;
        }
    </style>
</head>
<body>
    <header class="admin-header">
        <div class="admin-header-container">
            <a href="admin-dashboard.php"><h2>🎓 EduPath Admin Panel</h2></a>
            <nav>
                <a href="admin-dashboard.php">Dashboard</a>
                <a href="add-university.php">Add University</a>
                <a href="logout.php" onclick="return confirm('Logout now?')">Logout</a>
            </nav>
        </div>
    </header>
    <h1 class="dashboard-title">Add New University</h1>

    <div class="form-container">
        <?php if ($success): ?>
            <p class="success-message"><?= $success ?></p>
        <?php elseif ($error): ?>
            <p class="error-message"><?= $error ?></p>
        <?php endif; ?>

        <form method="POST" class="add-form">
            <label>University Name:</label>
            <input type="text" name="name" required>

            <label>Country:</label>
            <input type="text" name="country" required>

            <label>Image URL:</label>
            <input type="text" name="image_url" required>

            <label>Ranking:</label>
            <input type="number" name="ranking" min="1">

            <label>Description:</label>
            <textarea name="description" rows="5" required></textarea>

            <label>Select Categories:</label>
            <select name="category_ids[]" multiple required>
                <?php foreach ($allCategories as $cat): ?>
                    <option value="<?= $cat['category_id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
                <?php endforeach; ?>
            </select>
            <small>Hold Ctrl (Windows) or Cmd (Mac) to select multiple categories</small>

            <h3>Programs Offered</h3>
            <div id="programs-container">
                <div class="program-block">
                    <input type="text" name="programs[]" placeholder="Program Name" required>
                    <input type="text" name="levels[]" placeholder="Level (e.g., Bachelor's)" required>
                    <input type="number" name="durations[]" placeholder="Duration (years)" min="1" required>
                    <input type="number" step="0.01" name="fees[]" placeholder="Tuition Fee" required>
                </div>
            </div>

            <button type="button" onclick="addProgram()">+ Add Another Program</button>
            <br><br>
            <button type="submit">Add University</button>
        </form>
    </div>

    <script>
        function addProgram() {
            const container = document.getElementById('programs-container');
            const div = document.createElement('div');
            div.classList.add('program-block');
            div.innerHTML = `
                <input type="text" name="programs[]" placeholder="Program Name" required>
                <input type="text" name="levels[]" placeholder="Level (e.g., Bachelor's)" required>
                <input type="number" name="durations[]" placeholder="Duration (years)" min="1" required>
                <input type="number" step="0.01" name="fees[]" placeholder="Tuition Fee" required>
            `;
            container.appendChild(div);
        }
    </script>
</body>
</html>
