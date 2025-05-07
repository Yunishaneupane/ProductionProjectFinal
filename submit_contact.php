<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $firstname = htmlspecialchars($_POST["firstname"]);
  $lastname = htmlspecialchars($_POST["lastname"]);
  $jobtitle = htmlspecialchars($_POST["jobtitle"]);
  $institution = htmlspecialchars($_POST["institution"]);
  $email = htmlspecialchars($_POST["email"]);
  $message = htmlspecialchars($_POST["message"]);

  // You can email this, store in DB, etc. Here's a simple confirmation:
  echo "<h2>Thank you, $firstname!</h2>";
  echo "<p>We have received your message and will get back to you at $email.</p>";
} else {
  header("Location: contactus.php");
  exit();
}
?>
