<?php
session_start();
require_once "db.php";
$conn = db();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Library Search</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>

<h2>Library Search</h2>

<input type="text" id="searchInput" placeholder="Search by book name...">

<select id="categorySelect">
  <option value="all">All</option>
  <option value="novel">Novel</option>
  <option value="science">Science</option>
</select>

<div id="bookList"></div>

<script src="search.js"></script>
</body>
</html>
