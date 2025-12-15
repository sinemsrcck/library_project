<?php
session_start();
require_once "db.php";
$conn = db();

/*
  Buraya ileride DB bağlantısı ve kullanıcı kontrolü eklenecek:
  include "test_db.php";
  if (!isset($_SESSION["user_id"])) {
      header("Location: login.php");
      exit;
  }
*/
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<h2 style="text-align:center; margin-top:20px;">My Dashboard</h2>

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
