
<?php
require_once "config.php";

function db() {
    global $hn, $un, $pw, $db;
    $conn = new mysqli($hn, $un, $pw, $db);
    if ($conn->connect_error) die("Database connection failed: " . $conn->connect_error);
    $conn->set_charset("utf8mb4");
    return $conn;
}
session_start();


// Connect databases
require_once "db.php";
$conn = db();

if ($conn->connect_error) die("Connection error: " . $conn->connect_error);

// Get the book id from URL 
$book_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$user_id = 1; // fixed user for now (no Login)

$message = "";

// Get the book informations from database
$query = "SELECT * FROM books WHERE id = $book_id";
$result = $conn->query($query);
$book = $result ? $result->fetch_assoc() : null;

// Check if there is already a pending request for this user and book
$hasPending = false;

if ($book) {
    $user_id = 1; // şimdilik sabit kullanıcı
    $checkQ = "SELECT id FROM borrowings 
               WHERE user_id = $user_id AND book_id = $book_id AND status = 'pending'
               LIMIT 1";
    $checkR = $conn->query($checkQ);
    if ($checkR && $checkR->num_rows > 0) {
        $hasPending = true;
    }
    if ($checkR) $checkR->close();
}

// ----If borrow button clicked ----
if ($book && isset($_POST['borrow'])) {
    
   if ($book['is_available'] != 1) {
        $message = "<p style='color:red;'>This book is not available.</p>";
    } elseif ($hasPending) {
        $message = "<p style='color:orange;'>You already have a pending request for this book.</p>";
    } else {
        $borrow_date = date("Y-m-d");
        $due_date    = date("Y-m-d", strtotime("+10 days"));

        $ins = "INSERT INTO borrowings (user_id, book_id, borrow_date, due_date, status)
                VALUES ($user_id, $book_id, '$borrow_date', '$due_date', 'pending')";
    
//burası değişti,prevent duplicate borrow requests
        if ($conn->query($ins)) {
             
                $_SESSION['msg'] = "<p style='color:green;'>Request sent! It will be active after admin approval.</p>";
                header("Location: book_detail.php?id=$book_id");
                exit;
            

    } else {
        $message = "<p style='color:red;'>Hata: " . $conn->error . "</p>";
    }
}
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="styles.css">
    <meta charset="UTF-8">
    <title><?php echo $book ? htmlspecialchars($book['title']) : 'Kitap Bulunamadı'; ?></title>

</head>
<body>
<div class="container">
<!--“The Post/Redirect/Get pattern is used after form submission to prevent duplicate borrow requests caused by page refresh.”-->
<?php
if (isset($_SESSION['msg'])) {
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
}
?>

<?php
// If there is message after borrowing, it will be visible here
echo $message;
?>

<?php if ($book): ?>
    <div class="card">
        <h2><?php echo htmlspecialchars($book['title']); ?></h2>

    <p><strong>Yazar:</strong> <?php echo htmlspecialchars($book['author']); ?></p>
    <p><strong>Kategori:</strong> <?php echo htmlspecialchars($book['category']); ?></p>
    <p><strong>Yıl:</strong> <?php echo htmlspecialchars($book['year']); ?></p>
    <p><strong>ISBN:</strong> <?php echo htmlspecialchars($book['isbn']); ?></p>
    
    <!-- If is available equal 1, the borrow button is active else not -->
    <?php if ($book['is_available'] == 1): ?>
        <p style="color: green;">Kitap müsait</p>

       <?php if ($hasPending): ?>
        <p style="color: orange;">Bu kitap için zaten bekleyen bir isteğin var.</p>
        <button class="btn btn-disabled" disabled>Borrow</button>
   
        <?php else: ?>
        <form method="post" id="borrowForm">
            <button type="submit" name="borrow" class="btn btn-borrow">
                Borrow (Ödünç Al)
            </button>
        </form>
    <?php endif; ?>

    <?php else: ?>
        <p style="color: red;">Bu kitap şu anda uygun değil.</p>
        <button class="btn btn-disabled" disabled>Borrow</button>
    <?php endif; ?>
</div>
<?php else: ?>
    <p>Kitap bulunamadı.</p>
<?php endif; ?>
</div>
<script>
  const form = document.getElementById("borrowForm");
  if (form) {
    form.addEventListener("submit", function(e) {
      const ok = confirm("Send borrow request for this book?");
      if (!ok) e.preventDefault();
    });
  }
</script>

</body>
</html>

<?php
if ($result) $result->close();
$conn->close();
?>
