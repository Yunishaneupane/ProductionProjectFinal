<?php
session_start();
session_destroy();
header("Location: home.php"); // ✅ Redirect to homepage instead of login
exit;
