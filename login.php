<?php
session_start();
require 'database.php';
require 'vendor/autoload.php'; // PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signup'])) {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $role = $_POST["role"];
    $otp = rand(100000, 999999);

    $_SESSION['signup'] = compact('name', 'email', 'password', 'role', 'otp');

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
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <link rel="stylesheet" href="login.css">
  <title>Signup - EduPath</title>
</head>

<body>

  <div class="container" id="container">
    <div class="form-container sign-up">
      <form method="POST" action="">
        <h1>Create Account</h1>
        <span>or use your email for registration</span>
        
        <?php if (!empty($error)): ?>
          <p style="color: red; font-weight: bold;"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <input type="text" name="name" placeholder="Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <select name="role" required>
          <option value="" disabled selected>Select Role*</option>
          <option value="student">Student</option>
          <option value="admin">Admin</option>
          <option value="institution">Institution</option>
        </select>

        <button type="submit" name="signup">Sign Up</button>
      </form>
    </div>

    <div class="form-container sign-in">
      <form method="POST" action="login-process.php">
        <h1>Log In</h1>
        <span>or use your email password</span>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
   
        <a href="#">Forget Your Password?</a>
        <button type="submit">Log In</button>
      </form>
    </div>

    <div class="toggle-container">
      <div class="toggle">
        <div class="toggle-panel toggle-left">
          <h1>Welcome Back!</h1>
          <p>Enter your personal details to use all of site features</p>
          <button class="hidden" id="login">Sign In</button>
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

    registerBtn.addEventListener('click', () => {
      container.classList.add("active");
    });

    loginBtn.addEventListener('click', () => {
      container.classList.remove("active");
    });
  </script>

</body>

</html>
