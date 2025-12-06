<?php
require_once 'login.php';

// Veritabanına bağlan
$conn = new mysqli($hn, $un, $pw, $db);
if ($conn->connect_error) die("Bağlantı hatası: " . $conn->connect_error);

// URL'den kitap id'si al
$book_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// ---- Borrow butonuna basıldıysa ----
$message = "";

if (isset($_POST['borrow'])) {
    $user_id = 1; // Şimdilik sabit kullanıcı (login yok)

    $borrow_date = date("Y-m-d");
    $due_date    = date("Y-m-d", strtotime("+10 days"));

    $query = "
        INSERT INTO borrowings (user_id, book_id, borrow_date, due_date, status)
        VALUES ($user_id, $book_id, '$borrow_date', '$due_date', 'pending')
    ";

    if ($conn->query($query)) {
        $message = "<p style='color:green;'>İstek gönderildi! Admin onaylayınca aktif olacak.</p>";
    } else {
        $message = "<p style='color:red;'>Hata: " . $conn->error . "</p>";
    }
}

// ---- Kitap bilgilerini çek ----
$query = "SELECT * FROM books WHERE id = $book_id";
$result = $conn->query($query);
$book = $result ? $result->fetch_assoc() : null;

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


<?php
// Borrow sonrası mesaj (varsa) burada gözüksün
echo $message;
?>

<?php if ($book): ?>
    <div class="card">
        <h2><?php echo htmlspecialchars($book['title']); ?></h2>

    <p><strong>Yazar:</strong> <?php echo htmlspecialchars($book['author']); ?></p>
    <p><strong>Kategori:</strong> <?php echo htmlspecialchars($book['category']); ?></p>
    <p><strong>Yıl:</strong> <?php echo htmlspecialchars($book['year']); ?></p>
    <p><strong>ISBN:</strong> <?php echo htmlspecialchars($book['isbn']); ?></p>

    <?php if ($book['is_available'] == 1): ?>
        <p style="color: green;">Kitap müsait</p>

        <form method="post">
            <button type="submit" name="borrow" class="btn btn-borrow">
                Borrow (Ödünç Al)
            </button>
        </form>
    <?php else: ?>
        <p style="color: red;">Bu kitap şu anda uygun değil.</p>
        <button class="btn btn-disabled" disabled>Borrow</button>
    <?php endif; ?>
</div>
<?php else: ?>
    <p>Kitap bulunamadı.</p>
<?php endif; ?>
</div>
</body>
</html>
<?php
if ($result) $result->close();
$conn->close();
?>
