<?php
// Start session to access user and admin information
session_start();
// Include database connection
require_once "db.php";
$conn = db();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Library Search</title>
  <link rel="stylesheet" href="styles.css?v=<?php echo time(); ?>">
  <link rel="icon" href="images/favicon.ico" type="image/x-icon">
</head>

<body class="theme-library">

  <div class="navbar">
    <!-- Logo Left -->
    <a href="index.php">
      <img src="images/logo.png" alt="Logo" class="nav-logo">
    </a>

    <!-- Links Center -->
    <div class="nav-links">
      <a class="btn btn-primary" href="index.php">Home</a>
      <a class="btn btn-primary" href="dashboard.php">Dashboard</a>
      <a class="btn btn-primary" href="history.php">History</a>
      <!-- Show Admin link only if user is admin -->
      <?php if (!empty($_SESSION["is_admin"])): ?>
        <a class="btn btn-primary" href="admin.php">Admin</a>
      <?php endif; ?>
    </div>

    <!-- Actions Right -->
    <div class="nav-actions">
      <!-- Profile Icon -->
      <a href="profile.php" class="profile-icon-btn" title="My Profile">
        <svg viewBox="0 0 24 24">
          <path
            d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
        </svg>
      </a>
      <a class="btn btn-danger" href="logout.php">Logout</a>
    </div>
  </div>

  <h2>Library Search</h2>

  <input type="text" id="searchInput" placeholder="Search by book name...">

  <select id="categorySelect">
    <option value="all">All Categories</option>
    <?php
    // Fetch distinct book categories from database
    $catRes = $conn->query("SELECT DISTINCT category FROM books WHERE category IS NOT NULL AND category != '' ORDER BY category");
    if ($catRes) {
      while ($catRow = $catRes->fetch_assoc()) {
        $c = htmlspecialchars($catRow['category']);
        echo "<option value=\"$c\">$c</option>";
      }
    }
    ?>
  </select>

  <?php
  // Fetch all books from database
  $books = [];
  $res = $conn->query("SELECT id, title, category, cover_url, total_copies, available_copies FROM books ORDER BY id DESC");

  // Store books in array
  if ($res) {
    while ($row = $res->fetch_assoc()) {
      $books[] = $row;
    }
    $res->close();
  }
  ?>

  <!-- Book list will be rendered here by JavaScript -->
  <div id="bookList"></div>


  <script>
    // Pass PHP book data to JavaScript as JSON
    const booksFromDB = <?= json_encode($books, JSON_UNESCAPED_UNICODE); ?>;
  
  </script>
  <script src="search.js"></script>

</body>

</html>