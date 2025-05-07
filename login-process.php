<?php
session_start();
require 'database.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = $_POST["email"];
  $password = $_POST["password"];

  $stmt = $conn->prepare("SELECT * FROM Users WHERE email = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    if (password_verify($password, $user["password"])) {
      // Save user info in session
      $_SESSION["user"] = [
        "id" => $user["user_id"],
        "name" => $user["name"],
        "email" => $user["email"],
        "role" => $user["role"]
      ];
 // ADD these 2 lines:
 $_SESSION["user_id"] = $user["user_id"];
 $_SESSION["email"] = $user["email"];
      // Redirect by role
      switch ($user["role"]) {
        case "student":
          header("Location: home.php");
          break;
        case "admin":
          header("Location:Dashboard/index.php");
          break;
        case "institution":
          header("Location: institution-dashboard.php");
          break;
        default:
          echo "Unknown role. Contact support.";
          exit;
      }
      exit;
    } else {
      header("Location: login.php?error=" . urlencode("Incorrect password."));
      exit;
      
    }
  } else {
    header("Location: login.php?error=" . urlencode("User not found. Please register."));
    exit;
    
}
}
?>

<!DOCTYPE html>
<html>
<head><title>EduPath Login</title></head>
<body>
<h2>Login</h2>
<?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
<a href="login.php">Go back to login</a>
</body>
</html>
