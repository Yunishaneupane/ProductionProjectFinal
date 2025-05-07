<?php
session_start();

if (!empty($_SESSION["wishlist"])) {
    foreach ($_SESSION["wishlist"] as $item) {
        echo "<div class='wishlist-item'>";
        echo "<h3>" . htmlspecialchars($item["name"]) . "</h3>";
        echo "<p><strong>" . htmlspecialchars($item["country"]) . "</strong></p>";
        echo "<img src='" . htmlspecialchars($item["image_url"]) . "' alt='" . htmlspecialchars($item["name"]) . " Logo' class='wishlist-logo'>";
        echo "</div>";
    }
} else {
    echo "<p style='padding: 1rem;'>Your wishlist is empty.</p>";
}
?>
