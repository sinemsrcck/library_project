<?php
session_start();
require_once "db.php";
$conn = db();

$user_id = $_SESSION["user_id"] ?? $_SESSION["admin_id"] ?? 0;

if ($user_id === 0) {
  header("Location: login.php");
  exit;
}
// Book ID
$book_id = isset($_GET["id"]) ? (int)$_GET["id"] : 0;

if ($book_id <= 0) {
  header("Location: index.php");
  exit;
}


// Şimdilik sabit kullanıcı
$user_id = $_SESSION["user_id"] ?? 0;
if ($user_id === 0) {
   header("Location: login.php");
   exit;
}


$message = "";

// Get book
$query = "SELECT * FROM books WHERE id = $book_id";
$result = $conn->query($query);
$book = $result ? $result->fetch_assoc() : null;

// Check pending request
$hasPending = false;
if ($book) {
    $checkQ = "SELECT id FROM borrowings 
               WHERE user_id = $user_id 
               AND book_id = $book_id 
               AND status = 'pending'
               LIMIT 1";
    $checkR = $conn->query($checkQ);
    if ($checkR && $checkR->num_rows > 0) {
        $hasPending = true;
    }
    if ($checkR) $checkR->close();
}

// Borrow action (PRG pattern)
if ($book && isset($_POST["borrow"])) {

    if ($book["is_available"] != 1) {
        $message = "<p class='error'>This book is not available.</p>";
    } elseif ($hasPending) {
        $message = "<p class='warning'>You already have a pending request for this book.</p>";
    } else {

        $borrow_date = date("Y-m-d");
        $due_date = date("Y-m-d", strtotime("+10 days"));

        $ins = "INSERT INTO borrowings (user_id, book_id, borrow_date, due_date, status)
                VALUES ($user_id, $book_id, '$borrow_date', '$due_date', 'pending')";

        if ($conn->query($ins)) {
            $_SESSION["msg"] = "<p class='success'>
                Request sent! It will be active after admin approval.
            </p>";
            header("Location: book_detail.php?id=$book_id");
            exit;
        } else {
            $message = "<p class='error'>Error: {$conn->error}</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>
    <?php echo $book ? htmlspecialchars($book["title"]) : "Book Not Found"; ?>
  </title>
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

<div class="container">

<?php
// Session message (PRG)
if (isset($_SESSION["msg"])) {
    echo $_SESSION["msg"];
    unset($_SESSION["msg"]);
}

// Inline message
echo $message;
?>

<?php if ($book): ?>
<div class="book-detail">

  <!-- STATIK HTML TASARIM + DINAMIK DATA -->
  <?php
$cover = (!empty($book["cover_url"])) ? $book["cover_url"] : "book.jpg";
?>
<img 
  src="<?php echo htmlspecialchars($cover); ?>" 
  alt="Book Cover"
  style="width:100%; border-radius:10px; background:#f0f0f0; min-height:300px;"
  loading="eager"
>

  <h2><?php echo htmlspecialchars($book["title"]); ?></h2>

  <p><strong>Author:</strong> <?php echo htmlspecialchars($book["author"]); ?></p>
  <p><strong>Category:</strong> <?php echo htmlspecialchars($book["category"]); ?></p>
  <p><strong>ISBN:</strong> <?php echo htmlspecialchars($book["isbn"]); ?></p>

  <?php if ($book["is_available"] == 1): ?>
      <p class="available">Status: Available</p>

      <?php if ($hasPending): ?>
          <p class="warning">You already requested this book.</p>
          <button class="btn btn-disabled" disabled>Borrow</button>
      <?php else: ?>
          <form method="post" id="borrowForm">
              <button type="submit" name="borrow" class="btn btn-borrow">
                  Borrow
              </button>
          </form>
      <?php endif; ?>

  <?php else: ?>
      <p class="error">Status: Not Available</p>
      <button class="btn btn-disabled" disabled>Borrow</button>
  <?php endif; ?>

</div>
<?php else: ?>
<p>Book not found.</p>
<?php endif; ?>

</div>

<script>
const form = document.getElementById("borrowForm");
if (form) {
  form.addEventListener("submit", function(e) {
    if (!confirm("Send borrow request for this book?")) {
        e.preventDefault();
    }
  });
}
</script>

</body>
</html>

<?php
if ($result) $result->close();
$conn->close();
?>

