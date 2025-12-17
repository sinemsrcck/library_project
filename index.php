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
<body class="theme-library">


<h2>Library Search</h2>
<div class="navbar">
  <a class="btn btn-primary" href="index.php">Home</a>
  <a class="btn btn-primary" href="dashboard.php">Dashboard</a>
  <a class="btn btn-primary" href="history.php">History</a>

  <?php if (!empty($_SESSION["is_admin"])): ?>
    <a class="btn btn-primary" href="admin.php">Admin</a>
  <?php endif; ?>

  <a class="btn btn-danger" href="logout.php">Logout</a>
</div>

<input type="text" id="searchInput" placeholder="Search by book name...">

<select id="categorySelect">
  <option value="all">All</option>
  <option value="novel">Novel</option>
  <option value="science">Science</option>
</select>

<?php
// DB'den kitapları çek (hepsini)
$books = [];
$res = $conn->query("SELECT id, title, category, is_available FROM books ORDER BY id DESC");
if ($res) {
  while ($row = $res->fetch_assoc()) {
    $books[] = $row;
  }
  $res->close();
}
?>

<div id="bookList"></div>


<script>
  // PHP -> JS
  const booksFromDB = <?= json_encode($books, JSON_UNESCAPED_UNICODE); ?>;
</script>
<script src="search.js"></script>

</body>
</html>
