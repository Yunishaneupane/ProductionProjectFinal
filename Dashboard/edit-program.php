<?php
session_start();
require '../database.php';

if (!isset($_SESSION["university_id"])) {
    echo "Access denied.";
    exit;
}

$universityId = $_SESSION["university_id"];
$programId = isset($_GET['id']) ? intval($_GET['id']) : 0;

$success = "";
$error = "";

// Fetch program
$stmt = $conn->prepare("SELECT * FROM programs WHERE program_id = ? AND university_id = ?");
$stmt->bind_param("ii", $programId, $universityId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Program not found or permission denied.";
    exit;
}

$program = $result->fetch_assoc();

// Handle update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['program_name']);
    $level = trim($_POST['program_level']);
    $duration = intval($_POST['duration_years']);
    $fee = floatval($_POST['tuition_fee']);

    if ($name && $level && $duration > 0 && $fee >= 0) {
        $updateStmt = $conn->prepare("UPDATE programs SET program_name = ?, program_level = ?, duration_years = ?, tuition_fee = ? WHERE program_id = ? AND university_id = ?");
        $updateStmt->bind_param("ssiddi", $name, $level, $duration, $fee, $programId, $universityId);

        if ($updateStmt->execute()) {
            $success = "✅ Program updated successfully!";
            $program = ['program_name' => $name, 'program_level' => $level, 'duration_years' => $duration, 'tuition_fee' => $fee];
        } else {
            $error = "❌ Failed to update program.";
        }
    } else {
        $error = "❗ All fields are required and must be valid.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Program</title>
    <style>
        body {
            font-family: "Segoe UI", sans-serif;
            background: #f4f6fa;
            margin: 0;
        }

        /* === HEADER === */
        .admin-header {
            background-color: #2d3b4f;
            padding: 1rem 2rem;
            color: white;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .admin-header-container {
            max-width: 1200px;
            margin: auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: bold;
            display: flex;
            align-items: center;
            color: white;
        }

        .logo span {
            margin-left: 0.5rem;
        }

        .admin-nav a {
            margin-left: 2rem;
            color: white;
            text-decoration: none;
            font-weight: 600;
            position: relative;
            transition: color 0.3s ease;
        }

        .admin-nav a.active,
        .admin-nav a:hover {
            color: #a8d0ff;
        }

        .admin-nav a::after {
            content: "";
            position: absolute;
            bottom: -4px;
            left: 0;
            width: 0%;
            height: 2px;
            background: #a8d0ff;
            transition: width 0.3s ease;
        }

        .admin-nav a:hover::after,
        .admin-nav a.active::after {
            width: 100%;
        }

        /* === FORM === */
        .form-container {
            max-width: 600px;
            margin: 3rem auto;
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 1.5rem;
            color: #232946;
        }

        label {
            font-weight: bold;
            display: block;
            margin-top: 1rem;
            margin-bottom: 0.3rem;
        }

        input {
            width: 100%;
            padding: 10px;
            border: 1px solid #bbb;
            border-radius: 6px;
        }

        .form-container button {
            background-color: #0073e6;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            margin-top: 1.5rem;
            cursor: pointer;
        }

        .form-container .success {
            color: green;
            font-weight: bold;
            margin-bottom: 1rem;
            text-align: center;
        }

        .form-container .error {
            color: red;
            font-weight: bold;
            margin-bottom: 1rem;
            text-align: center;
        }

        .back-link {
            display: block;
            margin-top: 2rem;
            text-align: center;
            text-decoration: none;
            color: #0073e6;
            font-weight: bold;
        }
    </style>
</head>
<body>

<!-- Header -->
<header class="admin-header">
  <div class="admin-header-container">
    <div class="logo">
      🎓 <a href="index.php?view=dashboard" style="color: white; text-decoration: none;"><span>EduPath Institution Panel</span></a>
    </div>
    <nav class="admin-nav">
      <a href="index.php?view=dashboard">Dashboard</a>
      <a href="index.php?view=programs">Programs</a>
      <a href="index.php?view=manage">Manage Courses</a>
      <a href="../logout.php" onclick="return confirm('Logout now?')">Logout</a>
    </nav>
  </div>
</header>

<!-- Form -->
<div class="form-container">
    <h2>Edit Program</h2>

    <?php if ($success): ?>
        <div class="success"><?= $success ?></div>
    <?php elseif ($error): ?>
        <div class="error"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">
        <label>Program Name</label>
        <input type="text" name="program_name" value="<?= htmlspecialchars($program['program_name']) ?>" required>

        <label>Program Level</label>
        <input type="text" name="program_level" value="<?= htmlspecialchars($program['program_level']) ?>" required>

        <label>Duration (years)</label>
        <input type="number" name="duration_years" value="<?= $program['duration_years'] ?>" min="1" required>

        <label>Tuition Fee</label>
        <input type="number" name="tuition_fee" step="0.01" value="<?= $program['tuition_fee'] ?>" required>

        <button type="submit">Update Program</button>
    </form>

    <a href="index.php?view=manage" class="back-link">← Back to Manage Courses</a>
</div>

</body>
</html>
