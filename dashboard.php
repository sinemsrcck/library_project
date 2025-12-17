<?php
session_start();
require_once "db.php";
$conn = db();

  $user_id = $_SESSION["user_id"] ?? 0;
   if ($user_id === 0) {
   header("Location: login.php");
   exit;
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body class="theme-library">


<div class="navbar">
  <a class="btn btn-primary" href="index.php">Home</a>
  <a class="btn btn-primary" href="dashboard.php">Dashboard</a>
  <a class="btn btn-primary" href="history.php">History</a>

  <?php if (!empty($_SESSION["is_admin"])): ?>
    <a class="btn btn-primary" href="admin.php">Admin</a>
  <?php endif; ?>

  <a class="btn btn-danger" href="logout.php">Logout</a>
</div>

<div class="card-container">

    <div class="card">
        <h3>My Active Books</h3>
        <div id="activeBooksList">
            <!-- JS buraya liste ekleyecek -->
        </div>
    </div>

    <div class="card">
        <h3>Upcoming Due Dates</h3>
        <div id="dueDatesList">
            <!-- JS buraya liste ekleyecek -->
        </div>
    </div>

</div>

<script src="dashboard.js"></script>
</body>
</html>
