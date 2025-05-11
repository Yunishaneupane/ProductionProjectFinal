<?php
session_start();
require 'database.php';

$error = "";

// Check if login credentials are provided
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT * FROM Users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user["password"])) {
            $_SESSION["user"] = [
                "id" => $user["user_id"],
                "name" => $user["name"],
                "email" => $user["email"],
                "role" => $user["role"]
            ];

            // Redirect based on role
            if ($user["role"] === "student") {
                header("Location: home.php");
            } else if ($user["role"] === "admin") {
                header("Location: admin-dashboard.php");
            } else if ($user["role"] === "institution") {
                header("Location: institution-dashboard.php");
            }
            exit;
        } else {
            $error = "Incorrect password!";
            header("Location: login.php?error=" . urlencode($error)); // Redirect with error
            exit;
        }
    } else {
        $error = "User not found!";
        header("Location: login.php?error=" . urlencode($error)); // Redirect with error
        exit;
    }
}
?>
