<?php
session_start();
require 'database.php';

if (!isset($_SESSION['signup'])) {
    header("Location: signup.php");
    exit;
}

$signup = $_SESSION['signup'];
$university_id = $signup['university_id'] ?? null;

$success = $error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input_otp = implode("", $_POST["otp"]);
    if ($input_otp == $signup['otp']) {
        $stmt = $conn->prepare("INSERT INTO Users (name, email, password, role, university_id, registered_date) VALUES (?, ?, ?, ?, ?, NOW())");
        $stmt->bind_param("ssssi", $signup["name"], $signup["email"], $signup["password"], $signup["role"], $university_id);

        if ($stmt->execute()) {
            unset($_SESSION["signup"]);
            $success = "✅ Registered successfully! Redirecting to login...";
            header("refresh:3;url=login.php");
        } else {
            $error = "❌ Database Error: " . $stmt->error;
        }
    } else {
        $error = "❌ Invalid OTP. Please try again.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Verify OTP - EduPath</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <style>
    body {
      font-family: 'Inter', sans-serif;
      background: linear-gradient(to right, #dde5f2, #eef1f8);
      height: 100vh;
      margin: 0;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .container {
      background: white;
      width: 900px;
      height: 600px;
      border-radius: 20px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
      display: flex;
      overflow: hidden;
    }
    .left-panel {
      width: 50%;
      background: white;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 2rem;
    }
    .right-panel {
      width: 50%;
      background: linear-gradient(to bottom right, #232946, #2f3a5d);
      color: white;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 2rem;
    }
    h2 {
      margin-bottom: 1rem;
      font-size: 2rem;
    }
    .otp-boxes {
      display: flex;
      gap: 10px;
      margin: 1rem 0;
    }
    .otp-boxes input {
      width: 50px;
      height: 50px;
      font-size: 1.5rem;
      text-align: center;
      border: 2px solid #ddd;
      border-radius: 10px;
    }
    button {
      padding: 10px 20px;
      background: #5f4bb6;
      border: none;
      color: white;
      font-size: 1rem;
      border-radius: 8px;
      cursor: pointer;
      margin-top: 1rem;
    }
    .message {
      font-size: 1rem;
      margin: 10px 0;
    }
  </style>
</head>
<body>

<div class="container">
  <div class="left-panel">
    <h2>Verify Your Email</h2>

    <?php if ($success): ?>
      <p class="message" style="color: green;"><?= $success ?></p>
    <?php endif; ?>

    <?php if ($error): ?>
      <p class="message" style="color: red;"><?= $error ?></p>
    <?php endif; ?>

    <?php if (!$success): ?>
    <form method="POST">
      <div class="otp-boxes">
        <?php for ($i = 0; $i < 6; $i++): ?>
          <input type="text" name="otp[]" maxlength="1" required oninput="moveNext(this, <?= $i ?>)">
        <?php endfor; ?>
      </div>
      <button type="submit">Verify OTP</button>
    </form>
    <?php endif; ?>
  </div>

  <div class="right-panel">
    <h2>Hello, Friend!</h2>
    <p>Enter the OTP sent to your email<br><strong><?= htmlspecialchars($signup["email"]) ?></strong></p>
  </div>
</div>

<script>
function moveNext(current, index) {
  if (current.value.length === 1) {
    const inputs = document.querySelectorAll('input[name="otp[]"]');
    if (index < inputs.length - 1) {
      inputs[index + 1].focus();
    }
  }
}
document.querySelector('input[name="otp[]"]').focus();
</script>

</body>
</html>
