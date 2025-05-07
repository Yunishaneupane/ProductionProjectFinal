<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['transcript']) && $_FILES['transcript']['error'] === 0) {
        $file = $_FILES['transcript']['name'];
        $targetPath = "uploads/" . basename($file);

        if (!is_dir("uploads")) {
            mkdir("uploads", 0755, true);
        }

        if (move_uploaded_file($_FILES['transcript']['tmp_name'], $targetPath)) {
            $escapedPath = escapeshellarg($targetPath);

            // ✅ Full correct Python command
            $command = "python analyze_transcript.py $escapedPath 2>&1";
            $output = shell_exec($command);

            // ✅ Parse and save output
            $decoded = json_decode($output, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                file_put_contents("db/universities.json", json_encode($decoded, JSON_PRETTY_PRINT));
                header("Location: aboutus.php#transcript-results");
                exit();
            } else {
                echo "<pre>❌ Error parsing Python output:\n$output</pre>";
            }
        } else {
            echo "❌ File upload failed.";
        }
    }
}
?>
