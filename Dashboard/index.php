<?php
session_start();
require '../database.php';

if (!isset($_SESSION["university_id"])) {
  header("Location: ../login.php");
  exit;
}

$name = $_SESSION["name"] ?? "Institution";
$universityId = $_SESSION["university_id"];
$view = $_GET['view'] ?? 'dashboard'; // default view

// Fetch university info
$stmt = $conn->prepare("SELECT * FROM universities WHERE university_id = ?");
$stmt->bind_param("i", $universityId);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
  echo "<h2>University not found for this admin.</h2>";
  exit;
}
$university = $result->fetch_assoc();

// Fetch programs (for 'programs' or 'manage' view)
$programList = [];
if (in_array($view, ['programs', 'manage'])) {
  $prog_stmt = $conn->prepare("SELECT * FROM programs WHERE university_id = ?");
  $prog_stmt->bind_param("i", $universityId);
  $prog_stmt->execute();
  $programList = $prog_stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

// Program count (for dashboard)
$programCount = 0;
$prog_stmt = $conn->prepare("SELECT COUNT(*) as total FROM programs WHERE university_id = ?");
$prog_stmt->bind_param("i", $universityId);
$prog_stmt->execute();
$prog_result = $prog_stmt->get_result();
if ($row = $prog_result->fetch_assoc()) {
  $programCount = $row['total'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title><?= $university["name"] ?> - Dashboard</title>
  <style>
    body {
      margin: 0;
      font-family: "Segoe UI", sans-serif;
      background: #f9fbfd;
    }

    .hero {
      background: #eaf1f6;
      padding: 2rem;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .hero h1 {
      font-size: 2rem;
      margin: 0;
    }

    .hero p {
      font-size: 1.1rem;
      color: #444;
    }

    .avatar {
      width: 100px;
      height: 100px;
      border-radius: 50%;
      background: url('../assets/university-profile.png') no-repeat center center;
      background-size: cover;
    }

    .tabs {
      display: flex;
      padding: 1rem 2rem;
      border-bottom: 2px solid #ccc;
    }

    .tabs a {
      margin-right: 1.5rem;
      text-decoration: none;
      color: #777;
      font-weight: bold;
      padding-bottom: 0.5rem;
    }

    .tabs a.active {
      border-bottom: 2px solid #000;
      color: #000;
    }

    .content {
      display: flex;
      padding: 2rem;
    }

    .sidebar {
      min-width: 200px;
      margin-right: 2rem;
    }

    .sidebar button {
      display: block;
      background: transparent;
      border: none;
      font-size: 1rem;
      margin-bottom: 1rem;
      text-align: left;
      cursor: pointer;
      padding: 0.5rem;
      border-left: 4px solid transparent;
    }

    .sidebar button.active {
      font-weight: bold;
      border-left: 4px solid #0073e6;
      background: #f0f8ff;
    }

    .main-panel {
      flex: 1;
      background: white;
      padding: 2rem;
      border-radius: 10px;
      box-shadow: 0 4px 16px rgba(0, 0, 0, 0.05);
    }

    .card-grid {
      display: flex;
      flex-wrap: wrap;
      gap: 1rem;
      margin-top: 2rem;
    }

    .card {
      flex: 1 1 calc(33.33% - 1rem);
      background: #f6f8fa;
      padding: 1rem;
      border-radius: 8px;
      text-align: center;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
    }

    .main-panel h2 {
      margin-top: 0;
    }

    .main-panel p {
      color: #333;
      line-height: 1.6;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 1.5rem;
    }

    th,
    td {
      padding: 12px;
      border: 1px solid #ccc;
      text-align: left;
    }

    th {
      background: #f0f0f0;
    }

    a.action-link {
      margin-right: 8px;
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

    .welcome-hero {
      background-color: #eaf1f6;
      padding: 2rem 3rem;
    }

    .welcome-content {
      max-width: 1200px;
      margin: auto;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .welcome-content h1 {
      font-size: 2.2rem;
      font-weight: 700;
      margin: 0;
      color: #1a2e42;
    }

    .welcome-content p {
      font-size: 1.4rem;
      color: #2c3e50;
      margin-top: 0.4rem;
    }

    .welcome-avatar {
      width: 120px;
      height: 120px;
      background: url('../assets/welcome-avatar.png') no-repeat center center;
      background-size: cover;
      border-radius: 50%;
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
  <section class="welcome-hero">
    <div class="welcome-content">
      <div>
        <h1>Hello <?= htmlspecialchars($name) ?>,</h1>
        <p>Welcome to your profile!</p>
      </div>
      <div class="welcome-avatar"></div>
    </div>
  </section>

  <div class="content">


    <div class="main-panel">
      <?php if ($view == 'dashboard'): ?>
        <h2>Institution Summary</h2>
        <p><strong>University:</strong> <?= htmlspecialchars($university['name']) ?></p>
        <p><strong>Country:</strong> <?= htmlspecialchars($university['country']) ?></p>
        <p><strong>Ranking:</strong> #<?= htmlspecialchars($university['ranking']) ?></p>
        <p><strong>Description:</strong> <?= htmlspecialchars($university['description']) ?></p>

        <div class="card-grid">
          <div class="card"><?= $programCount ?> Active Programs</div>
          <div class="card">3 Pending Reviews</div>
          <div class="card">Edit Profile</div>
        </div>

      <?php elseif ($view == 'programs'): ?>
        <h2 style="display: flex; justify-content: space-between; align-items: center;">
          Your Programs
          <a href="add-program.php"
            style="background: #0073e6; color: white; padding: 8px 16px; border-radius: 5px; text-decoration: none; font-size: 14px;">+
            Add Program</a>
        </h2>

        <?php if (count($programList) === 0): ?>
          <p>No programs found.</p>
        <?php else: ?>
          <div class="card-grid">
            <?php foreach ($programList as $program): ?>
              <div class="card">
                <h3><?= htmlspecialchars($program['program_name']) ?></h3>
                <p><strong>Level:</strong> <?= htmlspecialchars($program['program_level']) ?></p>
                <p><strong>Duration:</strong> <?= $program['duration_years'] ?> years</p>
                <p><strong>Fee:</strong> $<?= number_format($program['tuition_fee'], 2) ?></p>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>


      <?php elseif ($view == 'manage'): ?>
        <h2>Manage Your Programs</h2>
        <?php if (count($programList) === 0): ?>
          <p>No programs found. <a href="add-program.php">Add one now →</a></p>
        <?php else: ?>
          <table>
            <thead>
              <tr>
                <th>Program Name</th>
                <th>Level</th>
                <th>Duration</th>
                <th>Fee</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($programList as $program): ?>
                <tr>
                  <td><?= htmlspecialchars($program['program_name']) ?></td>
                  <td><?= htmlspecialchars($program['program_level']) ?></td>
                  <td><?= $program['duration_years'] ?> years</td>
                  <td>$<?= number_format($program['tuition_fee'], 2) ?></td>
                  <td>
                    <a class="action-link" style="font-size:20px;text-decoration:none;" href="edit-program.php?id=<?= $program['program_id']  ?>">✏️</a>
                    <a class="action-link" style="font-size:20  px;text-decoration:none;" href="delete-program.php?id=<?= $program['program_id'] ?>"
                      onclick="return confirm('Are you sure?')">🗑 </a>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        <?php endif; ?>
      <?php endif; ?>
    </div>
  </div>

</body>

</html>