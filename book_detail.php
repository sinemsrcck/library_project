<?php
session_start();
require_once "db.php";
$conn = db();

// Giriş yapan kullanıcı ID'si alınıyor (admin veya normal kullanıcı olabilir)
$user_id = $_SESSION["user_id"] ?? $_SESSION["admin_id"] ?? 0;

// Giriş yapılmamışsa login sayfasına yönlendir
if ($user_id === 0) {
  header("Location: login.php");
  exit;
}
// URL'den gelen kitap ID'si alınır
$book_id = isset($_GET["id"]) ? (int) $_GET["id"] : 0;

// Kitap ID geçerli değilse anasayfaya yönlendir
if ($book_id <= 0) {
  header("Location: index.php");
  exit;
}

$message = "";

// Kitap bilgisi veritabanından çekilir
$query = "SELECT * FROM books WHERE id = $book_id";
$result = $conn->query($query);
$book = $result ? $result->fetch_assoc() : null;

// Kullanıcının bu kitap için önceden yaptığı istek kontrol edilir
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
  if ($checkR)
    $checkR->close();
}

// Kitap ödünç alma isteği (POST ile gönderildiyse çalışır)
if ($book && isset($_POST["borrow"])) {

  if ($book["is_available"] != 1) {
    $message = "<p class='error'>This book is not available.</p>";
  } elseif ($hasPending) {
    $message = "<p class='warning'>You already have a pending request for this book.</p>";
  } else {
    // Ödünç alma tarihi bugün, teslim tarihi 10 gün sonrası
    $borrow_date = date("Y-m-d");
    $due_date = date("Y-m-d", strtotime("+10 days"));

    
    // Veritabanına yeni istek eklenir (durum: pending)
    $ins = "INSERT INTO borrowings (user_id, book_id, borrow_date, due_date, status)
                VALUES ($user_id, $book_id, '$borrow_date', '$due_date', 'pending')";

    if ($conn->query($ins)) {
      // Başarılıysa mesaj kaydedilir ve sayfa yenilenir (PRG pattern)
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
  <!-- Kitap bilgisi başarılıysa -->
    <?php if ($book): ?>
      <div class="book-detail">

         <!-- Kapak resmi varsa gösterilir, yoksa default görsel -->
        <?php
        $cover = (!empty($book["cover_url"])) ? $book["cover_url"] : "book.jpg";
        ?>
        <img src="<?php echo htmlspecialchars($cover); ?>" alt="Book Cover"
          style="width:100%; border-radius:10px; background:#f0f0f0; min-height:300px;" loading="eager">

          <!-- Kitap bilgileri -->
        <h2><?php echo htmlspecialchars($book["title"]); ?></h2>

        <p><strong>Author:</strong> <?php echo htmlspecialchars($book["author"]); ?></p>
        <p><strong>Category:</strong> <?php echo htmlspecialchars($book["category"]); ?></p>
        <p><strong>ISBN:</strong> <?php echo htmlspecialchars($book["isbn"]); ?></p>

          <!-- Durum uygun ise kullanıcıya buton göster -->
        <?php if ($book["available_copies"] > 0): ?>
          <p class="available"><strong>Status:</strong> Available</p>


          <p><strong>Available Copies:</strong> <?= (int) $book["available_copies"] ?>/<?= (int) $book["total_copies"] ?>
          </p>

          <!-- Daha önce istek yapıldıysa buton disabled -->
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
          <p class="error"><strong>Status:</strong> Not Available</p>
          <button class="btn btn-disabled" disabled>Borrow</button>
        <?php endif; ?>

      </div>
    <?php else: ?>
      <p>Book not found.</p>
    <?php endif; ?>

  </div>

  <script>
    // Ödünç alma butonuna basıldığında kullanıcıdan onay alınır
    const form = document.getElementById("borrowForm");
    if (form) {
      form.addEventListener("submit", function (e) {
        if (!confirm("Send borrow request for this book?")) {
          e.preventDefault();
        }
      });
    }
  </script>

</body>

</html>

<?php
if ($result)
  $result->close();
$conn->close();
?>