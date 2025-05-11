<?php
session_start();
require '../database.php';

if (!isset($_SESSION["university_id"])) {
    echo "Access denied.";
    exit;
}

$universityId = $_SESSION["university_id"];
$programId = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($programId > 0) {
    // Ensure program belongs to the current university
    $checkStmt = $conn->prepare("SELECT program_id FROM programs WHERE program_id = ? AND university_id = ?");
    $checkStmt->bind_param("ii", $programId, $universityId);
    $checkStmt->execute();
    $result = $checkStmt->get_result();

    if ($result->num_rows > 0) {
        // Program exists and belongs to this university
        $delStmt = $conn->prepare("DELETE FROM programs WHERE program_id = ?");
        $delStmt->bind_param("i", $programId);
        if ($delStmt->execute()) {
            header("Location: index.php?view=manage&status=deleted");
            exit;
        } else {
            echo "❌ Failed to delete program.";
        }
    } else {
        echo "❗ You do not have permission to delete this program.";
    }
} else {
    echo "Invalid program ID.";
}
?>
