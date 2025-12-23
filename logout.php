<?php
session_start();// Start session to access current session data
session_unset();// Remove all session variables
session_destroy();// Destroy the session completely
header("Location: login.php"); // Redirect user to login page after logout
exit;
