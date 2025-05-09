<?php
session_start();
require '../database.php';

if (!isset($_SESSION["university_id"])) {
  header("Location: ../login.php");
  exit;
}

$name = $_SESSION["name"] ?? "Unknown";
$role = ucfirst($_SESSION["role"] ?? "admin");
$universityId = $_SESSION["university_id"];

$stmt = $conn->prepare("SELECT * FROM Universities WHERE university_id = ?");
$stmt->bind_param("i", $universityId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
  echo "<h2>University not found for this admin.</h2>";
  exit;
}

$selectedUniversity = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= $selectedUniversity["name"] ?> - Dashboard</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      background: #f4f6fa;
    }

    .header {
      background: #232946;
      color: white;
      padding: 1rem 2rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
      position: sticky;
      top: 0;
      z-index: 999;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .header h2 {
      margin: 0;
      font-size: 1.4rem;
    }

    .header .user-info {
      text-align: right;
      font-size: 0.95rem;
    }

    .header .logout-btn {
      background: #ff4d4d;
      color: white;
      border: none;
      padding: 8px 16px;
      border-radius: 6px;
      cursor: pointer;
      font-weight: bold;
      margin-left: 20px;
      transition: background-color 0.2s ease;
    }

    .header .logout-btn:hover {
      background: #e04343;
    }

    .dashboard {
      max-width: 800px;
      background: white;
      margin: 2rem auto;
      padding: 2rem;
      border-radius: 10px;
      box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
    }

    .dashboard img {
      width: 160px;
      border-radius: 10px;
      margin-bottom: 1.2rem;
    }

    .dashboard h1 {
      margin-bottom: 1rem;
      font-size: 1.8rem;
    }

    .dashboard p {
      font-size: 1rem;
      color: #333;
      margin: 0.5rem 0;
    }
  </style>
</head>
<body>

  <!-- Header with admin name, role, and logout -->
  <div class="header">
    <h2>EduPath Admin Dashboard</h2>
    <div class="user-info">
      Logged in as:<br>
      <strong><?= htmlspecialchars($name) ?></strong> (<?= htmlspecialchars($role) ?>)
      <form method="POST" action="../logout.php" style="display:inline;">
        <button class="logout-btn" type="submit">Logout</button>
      </form>
    </div>
  </div>

  <!-- Dashboard content -->
  <div class="dashboard">
    <img src="<?= htmlspecialchars($selectedUniversity["image_url"]) ?>" alt="University Logo">
    <h1>Welcome Admin of <?= htmlspecialchars($selectedUniversity["name"]) ?></h1>
    <p><strong>Country:</strong> <?= htmlspecialchars($selectedUniversity["country"]) ?></p>
    <p><strong>Ranking:</strong> #<?= htmlspecialchars($selectedUniversity["ranking"]) ?></p>
    <p><strong>Description:</strong> <?= htmlspecialchars($selectedUniversity["description"]) ?></p>
  </div>

</body>
</html>
