<?php
$host = "127.0.0.1:3307";  // Important: MariaDB is running on 3307
$dbname = "productionprojectfinal";
$username = "root";
$password = "";  // Or your real password if set

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
