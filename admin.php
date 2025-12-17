<?php
session_start();

if (empty($_SESSION["is_admin"])) {
  header("Location: login.php");
  exit;
}
require_once "db.php";
$conn = db();



?>
<?php
/// --- Borrow Request Onay İşlemi ---
if (isset($_POST['approve_id'])) {
    $id = (int)$_POST['approve_id'];

    // 1) status = approved
    $ok1 = $conn->query("UPDATE borrowings SET status = 'approved' WHERE id = $id");

    // 2) İlgili kitabın id'sini bul
    $book_id = null;
    $resBook = $conn->query("SELECT book_id FROM borrowings WHERE id = $id");
    if ($resBook && $row = $resBook->fetch_assoc()) {
        $book_id = (int)$row['book_id'];
    }
    if ($resBook) $resBook->close();

    // 3) Kitabı "müsait değil" yap
    $ok2 = true;
    if ($book_id !== null) {
        $ok2 = $conn->query("UPDATE books SET is_available = 0 WHERE id = $book_id");
    }

    if ($ok1 && $ok2) {
        echo "<p style='color:green;'>İstek onaylandı ve kitap artık müsait değil.</p>";
    } else {
        echo "<p style='color:red;'>Onay / güncelleme hatası: " . $conn->error . "</p>";
    }
}


if (isset($_POST['reject_id'])) {
    $id = (int)$_POST['reject_id'];

    $query = "UPDATE borrowings SET status = 'rejected' WHERE id = $id";
    if ($conn->query($query)) {
        echo "<p style='color:red;'>İstek reddedildi.</p>";
    } else {
        echo "<p style='color:red;'>Red hatası: " . $conn->error . "</p>";
    }
}


// --- Kitap Ekleme İşlemi ---
if (isset($_POST['add_book'])) {
    $title = $conn->real_escape_string($_POST['title']);
    $author = $conn->real_escape_string($_POST['author']);
    $category = $conn->real_escape_string($_POST['category']);
    $year = (int)$_POST['year'];
    $isbn = $conn->real_escape_string($_POST['isbn']);

    $query = "INSERT INTO books (title, author, category, year, isbn, is_available)
              VALUES ('$title', '$author', '$category', '$year', '$isbn', 1)";

    $result = $conn->query($query);

    if ($result) {
        echo "<p style='color:green;'>Kitap başarıyla eklendi!</p>";
    } else {
        echo "<p style='color:red;'>Hata oluştu: " . $conn->error . "</p>";
    }
}
// --- İade Alma İşlemi ---
if (isset($_POST['return_id'])) {
    $id = (int)$_POST['return_id'];

    // 1) İlgili kitabı bul
    $book_id = null;
    $resBook = $conn->query("SELECT book_id FROM borrowings WHERE id = $id");
    if ($resBook && $row = $resBook->fetch_assoc()) {
        $book_id = (int)$row['book_id'];
    }
    if ($resBook) $resBook->close();

    // 2) status = returned
    $ok1 = $conn->query("UPDATE borrowings SET status = 'returned' WHERE id = $id");

    // 3) Kitabı tekrar müsait yap
    $ok2 = true;
    if ($book_id !== null) {
        $ok2 = $conn->query("UPDATE books SET is_available = 1 WHERE id = $book_id");
    }

    if ($ok1 && $ok2) {
        echo "<p style='color:blue;'>Kitap iade alındı ve tekrar müsait.</p>";
    } else {
        echo "<p style='color:red;'>İade alma hatası: " . $conn->error . "</p>";
    }
}

// --- Kitap Silme İşlemi ---
if (isset($_POST['delete_id'])) {
    $id = (int)$_POST['delete_id'];
    $query = "DELETE FROM books WHERE id = $id";

    if ($conn->query($query)) {
        echo "<p style='color:red;'>Kitap başarıyla silindi!</p>";
    } else {
        echo "<p style='color:red;'>Silme hatası: " . $conn->error . "</p>";
    }
}


?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="styles.css">
    <meta charset="UTF-8">
    <title>Admin Panel</title>
</head>

<body class="theme-library">

   <div class="navbar">
  <a class="btn btn-primary" href="index.php">Home</a>
  <a class="btn btn-primary" href="dashboard.php">Dashboard</a>
  <a class="btn btn-primary" href="history.php">History</a>
  <a class="btn btn-danger" href="logout.php">Logout</a>
</div>

<div class="container">

    <h1>Admin Panel</h1>

    <!-- Kart 1: Kitap Ekle -->
    <div class="navbar">
        <h3>Kitap Ekle</h3>

        <form action="admin.php" method="post">
            <input type="text" name="title" placeholder="Kitap adı" required>
            <input type="text" name="author" placeholder="Yazar" required><br>
            <input type="text" name="category" placeholder="Kategori">
            <input type="number" name="year" placeholder="Yıl"><br>
            <input type="text" name="isbn" placeholder="ISBN">
            <button type="submit" name="add_book" class="btn btn-primary">Kitap Ekle</button>
        </form>
    </div>

    <!-- Bölüm 2: Mevcut Kitaplar -->
    <div class="card">
  <h3>Mevcut Kitaplar</h3>

  <?php
  $result = $conn->query("SELECT * FROM books");

  if ($result && $result->num_rows > 0) {
      echo "<table>
              <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Author</th>
                <th>Category</th>
                <th>Year</th>
                <th>Action</th>
              </tr>";

      while ($row = $result->fetch_assoc()) {
           $id = (int)$row['id'];
          echo "<tr>
                  <td>{$id}</td>
                  <td>" . htmlspecialchars($row['title']) . "</td>
                  <td>" . htmlspecialchars($row['author']) . "</td>
                  <td>" . htmlspecialchars($row['category']) . "</td>
                  <td>" . htmlspecialchars($row['year']) . "</td>
                  <td style='display:flex; gap:8px; align-items:center;'>
                    
                    <a href='book_detail.php?id={$id}' class='btn btn-primary'>Details</a>

                    <form method='post' action='admin.php' style='margin:0;'>
                      <input type='hidden' name='delete_id' value='{$id}'>
                      <button type='submit' class='btn btn-danger'>Sil</button>
                    </form>
                  </td>
                </tr>";
      }

      echo "</table>";
  } else {
      echo "<p>Henüz kitap yok.</p>";
  }
  ?>
</div>


<!-- Bölüm 3: Ödünç Alma İstekleri -->
<div class="section">
    <h3>Bekleyen Ödünç Alma İstekleri</h3>

    <?php
    // pending borrow request'leri çek
    $query = "
        SELECT br.id, u.fullname AS user_name, b.title AS book_title,
               br.borrow_date, br.due_date, br.status
        FROM borrowings br
        JOIN users u ON br.user_id = u.id
        JOIN books b ON br.book_id = b.id
        WHERE br.status = 'pending'
        ORDER BY br.borrow_date DESC
    ";
    $resReq = $conn->query($query);

    if ($resReq && $resReq->num_rows > 0) {
        echo "<table>";
        echo "<tr>
                <th>ID</th>
                <th>Kullanıcı</th>
                <th>Kitap</th>
                <th>Borrow Date</th>
                <th>Due Date</th>
                <th>İşlem</th>
              </tr>";

        while ($r = $resReq->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$r['id']}</td>";
            echo "<td>{$r['user_name']}</td>";
            echo "<td>{$r['book_title']}</td>";
            echo "<td>{$r['borrow_date']}</td>";
            echo "<td>{$r['due_date']}</td>";

            echo "<td>
                    <form action='admin.php' method='post' style='display:inline-block;'>
                        <input type='hidden' name='approve_id' value='{$r['id']}'>
                        <button type='submit' class='btn-approve'>Onayla</button>
                    </form>
                    <form action='admin.php' method='post' style='display:inline-block; margin-left:5px;'>
                        <input type='hidden' name='reject_id' value='{$r['id']}'>
                        <button type='submit' class='btn-reject'>Reddet</button>
                    </form>
                  </td>";

            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "<p>Şu anda bekleyen ödünç alma isteği yok.</p>";
    }

    if ($resReq) $resReq->close();
    ?>
</div>
<!-- Bölüm 4: Onaylanmış ve iade bekleyenler -->
<div class="section">
    <h3>Onaylanmış Ödünçler (İade Bekleyenler)</h3>

    <?php
    $qApproved = "
        SELECT br.id, u.fullname AS user_name, b.title AS book_title,
               br.borrow_date, br.due_date
        FROM borrowings br
        JOIN users u ON br.user_id = u.id
        JOIN books b ON br.book_id = b.id
        WHERE br.status = 'approved'
        ORDER BY br.borrow_date DESC
    ";
    $resApproved = $conn->query($qApproved);

    if ($resApproved && $resApproved->num_rows > 0) {
        echo "<table>";
        echo "<tr>
                <th>ID</th>
                <th>Kullanıcı</th>
                <th>Kitap</th>
                <th>Borrow Date</th>
                <th>Due Date</th>
                <th>İşlem</th>
              </tr>";

        while ($r = $resApproved->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$r['id']}</td>";
            echo "<td>{$r['user_name']}</td>";
            echo "<td>{$r['book_title']}</td>";
            echo "<td>{$r['borrow_date']}</td>";
            echo "<td>{$r['due_date']}</td>";

            echo "<td>
                    <form action='admin.php' method='post'>
                        <input type='hidden' name='return_id' value='{$r['id']}'>
                        <button type='submit' class='btn-approve'>İade Al</button>
                    </form>
                  </td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "<p>İade bekleyen onaylanmış kayıt yok.</p>";
    }

    if ($resApproved) $resApproved->close();
    ?>
</div>
</div>
</body>
</html>

