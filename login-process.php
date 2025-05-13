<?php
session_start();
require 'database.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT * FROM Users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user["password"])) {
            $_SESSION["user"] = [
                "id" => $user["user_id"],
                "name" => $user["name"],
                "email" => $user["email"],
                "role" => $user["role"],
                "university_id" => $user["university_id"] ?? null
            ];

            // Optional flat keys
            $_SESSION["user_id"] = $user["user_id"];
            $_SESSION["name"] = $user["name"];
            $_SESSION["role"] = $user["role"];
            $_SESSION["email"] = $user["email"];
            $_SESSION["university_id"] = $user["university_id"] ?? null;

            // ✅ Redirect based on role
            switch (strtolower($user["role"])) {
                case "student":
                    header("Location: home.php");
                    exit;

                case "admin":
                    header("Location: admin-dashboard.php");
                    exit;

                case "institution":
                    header("Location: Dashboard/index.php");
                    exit;

                default:
                    echo "Unknown role. Contact support.";
                    exit;
            }
        } else {
           
            header("Location: login.php?mode=login&error=Invalid password");
            exit;
        }
    } else {
       
        header("Location: login.php?mode=login&error=User not found");
        exit;
    }
} else {

    header("Location: login.php?mode=login&error=Invalid request");
    exit;
}
?>
