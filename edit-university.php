<?php
require 'database.php';
session_start();

// Restrict to admin
if (!isset($_SESSION["user"]) || $_SESSION["user"]["role"] !== 'admin') {
    echo "Access denied.";
    exit;
}

$success = "";
$error = "";

if (!isset($_GET['id'])) {
    echo "Invalid university ID.";
    exit;
}

$universityId = intval($_GET['id']);

// Fetch all categories
$categoryRes = $conn->query("SELECT * FROM category");
$allCategories = [];
while ($row = $categoryRes->fetch_assoc()) {
    $allCategories[] = $row;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $country = trim($_POST['country']);
    $imageUrl = trim($_POST['image_url']);
    $ranking = isset($_POST['ranking']) ? intval($_POST['ranking']) : null;
    $description = isset($_POST['description']) ? trim($_POST['description']) : '';
    $categoryIds = isset($_POST['category_ids']) ? implode(',', $_POST['category_ids']) : '';

    if ($name && $country && $imageUrl && $description) {
        $updateQuery = "UPDATE universities SET name = ?, country = ?, image_url = ?, ranking = ?, description = ?, category_id = ? WHERE university_id = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("sssissi", $name, $country, $imageUrl, $ranking, $description, $categoryIds, $universityId);

        if ($stmt->execute()) {
            // Update programs
           if (
    isset($_POST['program_ids'], $_POST['programs'], $_POST['levels'], $_POST['durations'], $_POST['fees']) &&
    is_array($_POST['programs'])
) {
    $programIds = $_POST['program_ids'];
    $programs = $_POST['programs'];
    $levels = $_POST['levels'];
    $durations = $_POST['durations'];
    $fees = $_POST['fees'];

    for ($i = 0; $i < count($programs); $i++) {
        $pname = trim($programs[$i]);
        $plevel = trim($levels[$i]);
        $pduration = intval($durations[$i]);
        $pfee = floatval($fees[$i]);

        if (!empty($programIds[$i])) {
            $pid = intval($programIds[$i]);
            $prog_stmt = $conn->prepare("UPDATE programs SET program_name = ?, program_level = ?, duration_years = ?, tuition_fee = ? WHERE program_id = ? AND university_id = ?");
            $prog_stmt->bind_param("ssiddi", $pname, $plevel, $pduration, $pfee, $pid, $universityId);
        } else {
            $prog_stmt = $conn->prepare("INSERT INTO programs (university_id, program_name, program_level, duration_years, tuition_fee) VALUES (?, ?, ?, ?, ?)");
            $prog_stmt->bind_param("issid", $universityId, $pname, $plevel, $pduration, $pfee);
        }

        if ($prog_stmt) {
            $prog_stmt->execute();
        }
    }
}


            $success = "✅ University and programs updated successfully!";
        } else {
            $error = "❌ Failed to update university.";
        }
    } else {
        $error = "❗ All fields except ranking are required.";
    }
}

// Fetch university info
$query = "SELECT * FROM universities WHERE university_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $universityId);
$stmt->execute();
$result = $stmt->get_result();
$university = $result->fetch_assoc();

// Prepare category selections
$selectedCategories = explode(',', $university['category_id'] ?? '');

// Fetch programs
$programs = [];
$pstmt = $conn->prepare("SELECT * FROM programs WHERE university_id = ?");
$pstmt->bind_param("i", $universityId);
$pstmt->execute();
$presult = $pstmt->get_result();
while ($row = $presult->fetch_assoc()) {
    $programs[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit University</title>
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

<h1 class="dashboard-title">Edit University</h1>

<div class="form-container">
    <?php if ($success): ?>
        <p class="success-message"><?= $success ?></p>
    <?php elseif ($error): ?>
        <p class="error-message"><?= $error ?></p>
    <?php endif; ?>

    <form method="POST" class="add-form">
        <label>University Name:</label>
        <input type="text" name="name" value="<?= htmlspecialchars($university['name']) ?>" required>

        <label>Country:</label>
        <input type="text" name="country" value="<?= htmlspecialchars($university['country']) ?>" required>

        <label>Image URL:</label>
        <input type="text" name="image_url" value="<?= htmlspecialchars($university['image_url']) ?>" required>

        <label>Ranking (optional):</label>
        <input type="number" name="ranking" min="1" value="<?= htmlspecialchars($university['ranking']) ?>">

        <label>Description:</label>
        <textarea name="description" rows="5" required><?= htmlspecialchars($university['description']) ?></textarea>

        <label>Select Categories:</label>
        <select name="category_ids[]" multiple required>
            <?php foreach ($allCategories as $cat): ?>
                <option value="<?= $cat['category_id'] ?>" <?= in_array($cat['category_id'], $selectedCategories) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($cat['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <small>Hold Ctrl (Windows) or Cmd (Mac) to select multiple categories</small>

        <h3>Programs</h3>
        <div id="programs-container">
            <?php foreach ($programs as $program): ?>
                <div class="program-block">
                    <input type="hidden" name="program_ids[]" value="<?= $program['program_id'] ?>">
                    <input type="text" name="programs[]" value="<?= htmlspecialchars($program['program_name']) ?>" placeholder="Program Name" required>
                    <input type="text" name="levels[]" value="<?= htmlspecialchars($program['program_level']) ?>" placeholder="Level" required>
                    <input type="number" name="durations[]" value="<?= $program['duration_years'] ?>" placeholder="Duration (years)" required>
                    <input type="number" step="0.01" name="fees[]" value="<?= $program['tuition_fee'] ?>" placeholder="Tuition Fee" required>
                </div>
            <?php endforeach; ?>
        </div>

        <button type="button" onclick="addProgram()">+ Add More Program</button>
        <br><br>
        <button type="submit">Update University</button>
    </form>
</div>

<script>
function addProgram() {
    const container = document.getElementById('programs-container');
    const div = document.createElement('div');
    div.className = 'program-block';
    div.innerHTML = `
        <input type="hidden" name="program_ids[]" value="">
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
