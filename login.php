<?php
session_start();
require 'database.php';
require 'vendor/autoload.php'; // PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$error = "";
$success = "";

// Fetch universities for dropdown
$universityStmt = $conn->prepare("SELECT university_id, name FROM Universities");
$universityStmt->execute();
$universities = $universityStmt->get_result();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signup'])) {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $role = $_POST["role"];
    $otp = rand(100000, 999999);
    $university_id = isset($_POST["university_id"]) ? $_POST["university_id"] : null;

    $_SESSION['signup'] = compact('name', 'email', 'password', 'role', 'otp', 'university_id');

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'productionproject4@gmail.com';
        $mail->Password   = 'zzmn jphc heqf uqsp';
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        $mail->setFrom('productionproject4@gmail.com', 'EduPath OTP');
        $mail->addAddress($email, $name);

        $mail->Subject = 'Your OTP Code';
        $mail->Body    = "Hi $name,\n\nYour OTP is: $otp\n\nUse this to verify your account.";

        $mail->send();
        header("Location: verify.php");
        exit;
    } catch (Exception $e) {
        $error = "❌ OTP email could not be sent. Error: {$mail->ErrorInfo}";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"/>
  <!-- Toastify CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

<!-- Toastify JS -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

  <link rel="stylesheet" href="login.css"/>
  <title>Signup - EduPath</title>
</head>

<body>
<div class="container" id="container">
  <!-- Sign Up Form -->
  <div class="form-container sign-up">
    <form method="POST" action="">
      <h1>Create Account</h1>
      <span>or use your email for registration</span>

      <?php if (!empty($error)): ?>
        <p style="color: red; font-weight: bold;"><?= htmlspecialchars($error) ?></p>
      <?php endif; ?>

      <input type="text" name="name" placeholder="Name" required />
      <input type="email" name="email" placeholder="Email" required />
      <input type="password" name="password" placeholder="Password" required />

      <select name="role" id="role-select" required>
        <option value="" disabled selected>Select Role*</option>
        <option value="student">Student</option>
        <option value="admin">Admin</option>
        <option value="institution">Institution</option>
      </select>

      <!-- University Dropdown (only for admin) -->
      <div id="university-dropdown" style="display: none; margin-top: 10px;">
  <select name="university_id" required>
    <option value="" disabled selected>Select University</option>
    <?php foreach ($universities as $uni): ?>
      <option value="<?= $uni['university_id'] ?>"><?= htmlspecialchars($uni['name']) ?></option>
    <?php endforeach; ?>
  </select>
</div>

      <button type="submit" name="signup">Sign Up</button>
    </form>
  </div>

  <!-- Log In Form -->
 <div class="form-container sign-in">
    <form method="POST" action="login-process.php">
      <h1>Log In</h1>
      <span>or use your email and password</span>

      <input type="email" name="email" placeholder="Email" required />
      <input type="password" name="password" placeholder="Password" required />
      <a href="#">Forget Your Password?</a>
      <button type="submit">Log In</button>
    </form>
  </div>
  <!-- Panel for animation -->
  <div class="toggle-container">
    <div class="toggle">
      <div class="toggle-panel toggle-left">
        <h1>Welcome Back!</h1>
        <p>Enter your personal details to use all of site features</p>
        <button class="hidden" id="login">Log In</button>
      </div>
      <div class="toggle-panel toggle-right">
        <h1>Hello, Friend!</h1>
        <p>Register with your personal details to use all of site features</p>
        <button class="hidden" id="register">Sign Up</button>
      </div>
    </div>
  </div>
</div>

<script>
  const container = document.getElementById('container');
  const registerBtn = document.getElementById('register');
  const loginBtn = document.getElementById('login');
  const roleSelect = document.getElementById('role-select');
  const universityDropdown = document.getElementById('university-dropdown');

  registerBtn.addEventListener('click', () => {
    container.classList.add("active");
  });

  loginBtn.addEventListener('click', () => {
    container.classList.remove("active");
  });

  roleSelect.addEventListener('change', function () {
    if (this.value === 'institution') {
      universityDropdown.style.display = 'block';
    } else {
      universityDropdown.style.display = 'none';
    }
  });
  
  <script>
    <?php if (isset($_GET['error'])): ?>
      document.addEventListener("DOMContentLoaded", function () {
        Toastify({
          text: "<?= htmlspecialchars($_GET['error']) ?>",
          duration: 3000,
          close: true,
          gravity: "top",
          position: "center",
          backgroundColor: "#ff4d4f",
        }).showToast();
      });

  </script>
<?php endif; ?>

</script>
</body>
</html>
