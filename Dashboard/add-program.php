<?php
session_start();
require '../database.php';

if (!isset($_SESSION["university_id"])) {
    echo "Access denied.";
    exit;
}

$universityId = $_SESSION["university_id"];
$success = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $programs = $_POST['programs'];
    $levels = $_POST['levels'];
    $durations = $_POST['durations'];
    $fees = $_POST['fees'];

    for ($i = 0; $i < count($programs); $i++) {
        $pname = trim($programs[$i]);
        $plevel = trim($levels[$i]);
        $pduration = intval($durations[$i]);
        $pfee = floatval($fees[$i]);

        if ($pname && $plevel && $pduration > 0 && $pfee >= 0) {
            $stmt = $conn->prepare("INSERT INTO programs (university_id, program_name, program_level, duration_years, tuition_fee) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("issid", $universityId, $pname, $plevel, $pduration, $pfee);
            $stmt->execute();
        }
    }

    $success = "✅ Program(s) added successfully!";
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Add New Program</title>
    <link rel="stylesheet" href="admin-dashboard.css">
    <style>
        body {
            font-family: "Segoe UI", sans-serif;
            background-color: #f4f6fa;
            margin: 0;
        }

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

        .form-container {
            max-width: 700px;
            margin: 2rem auto;
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        }

        .add-form label {
            display: block;
            margin-top: 1rem;
            margin-bottom: 0.3rem;
            font-weight: bold;
            color: #333;
        }

        .add-form input,
        .add-form textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #bbb;
            border-radius: 6px;
            box-sizing: border-box;
        }

        .program-block {
            margin-bottom: 20px;
            padding: 1rem;
            border: 1px solid #ccc;
            border-radius: 8px;
            background: #f9f9f9;
        }

        .add-form button {
            background-color: #0073e6;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            margin-top: 1rem;
            font-weight: bold;
            cursor: pointer;
        }

        .add-form button:hover {
            background-color: #005bb5;
        }

        .success-message {
            color: green;
            font-weight: bold;
            text-align: center;
        }

        .error-message {
            color: red;
            font-weight: bold;
            text-align: center;
        }
    </style>
</head>
<body>


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


<div class="form-container">
    <?php if ($success): ?>
        <p class="success-message"><?= $success ?></p>
    <?php elseif ($error): ?>
        <p class="error-message"><?= $error ?></p>
    <?php endif; ?>

    <form method="POST" class="add-form">
        <div id="programs-container">
            <div class="program-block">
                <label>Program Name</label>
                <input type="text" name="programs[]" placeholder="Program Name" required>

                <label>Level</label>
                <input type="text" name="levels[]" placeholder="Level (e.g., Bachelor's)" required>

                <label>Duration (years)</label>
                <input type="number" name="durations[]" min="1" placeholder="Duration (e.g., 3)" required>

                <label>Tuition Fee</label>
                <input type="number" step="0.01" name="fees[]" placeholder="Tuition Fee" required>
            </div>
        </div>

        <button type="button" onclick="addProgram()">+ Add Another Program</button>
        <br><br>
        <button type="submit">Add Program(s)</button>
    </form>
</div>

<script>
function addProgram() {
    const container = document.getElementById('programs-container');
    const div = document.createElement('div');
    div.classList.add('program-block');
    div.innerHTML = `
        <label>Program Name</label>
        <input type="text" name="programs[]" placeholder="Program Name" required>

        <label>Level</label>
        <input type="text" name="levels[]" placeholder="Level (e.g., Bachelor's)" required>

        <label>Duration (years)</label>
        <input type="number" name="durations[]" min="1" placeholder="Duration (e.g., 3)" required>

        <label>Tuition Fee</label>
        <input type="number" step="0.01" name="fees[]" placeholder="Tuition Fee" required>
    `;
    container.appendChild(div);
}
</script>

</body>
</html>
