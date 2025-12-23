<?php
session_start();
require_once "db.php";
$conn = db();



if (empty($_SESSION["is_admin"])) {
    header("Location: login.php");
    exit;
}



?>
<?php
/// --- Borrow Request Onay İşlemi ---
if (isset($_POST['approve_id'])) {
    $id = (int) $_POST['approve_id'];

    // 1) status = approved
    $ok1 = $conn->query("UPDATE borrowings SET status = 'approved' WHERE id = $id");

    // 2) İlgili kitabın id'sini bul
    $book_id = null;
    $resBook = $conn->query("SELECT book_id FROM borrowings WHERE id = $id");
    if ($resBook && $row = $resBook->fetch_assoc()) {
        $book_id = (int) $row['book_id'];
    }
    if ($resBook)
        $resBook->close();


    // 3) Kitabın available_copies sayısını 1 azalt
    $ok2 = true;
    if ($book_id !== null) {
        $ok2 = $conn->query("UPDATE books SET available_copies = available_copies - 1 WHERE id = $book_id AND available_copies > 0");
    }


    if ($ok1 && $ok2) {
        echo "<p style='color:green;'>İstek onaylandı ve kitap artık müsait değil.</p>";
    } else {
        echo "<p style='color:red;'>Onay / güncelleme hatası: " . $conn->error . "</p>";
    }
}


if (isset($_POST['reject_id'])) {
    $id = (int) $_POST['reject_id'];

    $query = "UPDATE borrowings SET status = 'rejected' WHERE id = $id";
    if ($conn->query($query)) {
        echo "<p style='color:red;'>İstek reddedildi.</p>";
    } else {
        echo "<p style='color:red;'>Red hatası: " . $conn->error . "</p>";
    }
}


// --- Kitap Ekleme İşlemi ---
if (isset($_POST['add_book'])) {
    $errors = []; // Hata listesi başlat

    // Verileri güvenli şekilde al
    $title = $conn->real_escape_string(trim($_POST['title'] ?? ''));
    $author = $conn->real_escape_string(trim($_POST['author'] ?? ''));
    $category = $conn->real_escape_string(trim($_POST['category'] ?? ''));
    $year = (int) ($_POST['year'] ?? 0);
    $isbn = $conn->real_escape_string(trim($_POST['isbn'] ?? ''));
    $cover_url = $conn->real_escape_string(trim($_POST['cover_url'] ?? ''));

    // Gerekli alanlar kontrolü
    if (empty($title) || empty($author) || empty($category)) {
        $errors[] = "Başlık, yazar ve kategori boş olamaz.";
    }

    // ISBN boşsa hata ver
    if (empty($isbn)) {
        $errors[] = "ISBN alanı boş olamaz.";
    }

    // Hata yoksa veritabanına ekle
    if (empty($errors)) {
        $query = "INSERT INTO books (title, author, category, year, isbn, cover_url, total_copies, available_copies)
                  VALUES ('$title', '$author', '$category', $year, '$isbn', '$cover_url', 1, 1)";
        $result = $conn->query($query);

        if ($result) {
            echo "<p style='color:green;'>Kitap başarıyla eklendi.</p>";
        } else {
            echo "<p style='color:red;'>Hata oluştu: " . $conn->error . "</p>";
        }
    } else {
        // Hataları yazdır
        foreach ($errors as $error) {
            echo "<p style='color:red;'>$error</p>";
        }
    }
}
// --- İade Alma İşlemi ---
if (isset($_POST['return_id'])) {
    $id = (int) $_POST['return_id'];

    // 1) İlgili kitabı bul
    $book_id = null;
    $resBook = $conn->query("SELECT book_id FROM borrowings WHERE id = $id");
    if ($resBook && $row = $resBook->fetch_assoc()) {
        $book_id = (int) $row['book_id'];
    }
    if ($resBook)
        $resBook->close();

    // 2) status = returned
    $ok1 = $conn->query("UPDATE borrowings SET status = 'returned' WHERE id = $id");

    // 3) Kitabı tekrar müsait yap
    // 3) Kitabın available_copies sayısını 1 artır
    $ok2 = true;
    if ($book_id !== null) {
        $ok2 = $conn->query("UPDATE books SET available_copies = available_copies + 1 WHERE id = $book_id AND available_copies < total_copies");
    }


    if ($ok1 && $ok2) {
        echo "<p style='color:blue;'>Kitap iade alındı ve tekrar müsait.</p>";
    } else {
        echo "<p style='color:red;'>İade alma hatası: " . $conn->error . "</p>";
    }
}

// --- Kitap Silme İşlemi ---
if (isset($_POST['delete_id'])) {
    $id = (int) $_POST['delete_id'];
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
    <link rel="stylesheet" href="styles.css?v=<?php echo time(); ?>">
    <meta charset="UTF-8">
    <title>Admin Panel</title>
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
            <a class="btn btn-primary" href="admin.php">Admin Panel</a>
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

        <h1>Admin Panel</h1>

        <!-- Kart 1: Kitap Ekle -->
        <div class="card">
            <h3>Kitap Ekle</h3>


            <div class="book-search-box">
                <input type="text" id="bookSearch" class="bookSearchInput" placeholder="Kitap adı yaz..."
                    autocomplete="off">

            </div>


            <div id="bookResults" style="
        border:1px solid #ccc;
        border-radius:6px;
        margin-top:5px;
        margin-bottom:15px;
        max-height:200px;
        overflow:auto;
        display:none;
        background:#fff;
    "></div>
            <form action="admin.php" method="post">
                <input type="text" name="title" id="title" placeholder="Kitap adı" required>
                <input type="text" name="author" id="author" placeholder="Yazar" required><br>

                <input type="text" name="category" id="category" placeholder="Kategori">
                <input type="number" name="year" id="year" placeholder="Year">
                <input type="text" name="isbn" id="isbn" placeholder="ISBN" class="form-control" required>
                <input type="hidden" name="cover_url" id="cover_url">
                <button type="submit" name="add_book" class="btn btn-primary">
                    Kitap Ekle
                </button>

            </form>
        </div>

        <!-- Bölüm 2: Mevcut Kitaplar -->
        <div class="card">
            <h3>Mevcut Kitaplar</h3>

            <?php
            $result = $conn->query("SELECT * FROM books");

            if ($result && $result->num_rows > 0) {
                echo "<table id='books-table'>
              <tr>
                <th>#</th>
                <th>Title</th>
                <th>Author</th>
                <th>Category</th>
                <th>Action</th>
              </tr>";

                $counter = 1;
                while ($row = $result->fetch_assoc()) {
                    $id = (int) $row['id'];

                    $rowClass = $counter > 5 ? "class='book-row hidden'" : "";

                    echo "<tr {$rowClass}>
                  <td>{$counter}</td>
                  <td>" . htmlspecialchars($row['title']) . "</td>
                  <td>" . htmlspecialchars($row['author']) . "</td>
                  <td>" . htmlspecialchars($row['category']) . "</td>
                  <td style='display:flex; gap:8px; align-items:center;'>
                    
                    <a href='book_detail.php?id={$id}' class='btn btn-primary'>Details</a>

                    <form method='post' action='admin.php' style='margin:0;'>
                      <input type='hidden' name='delete_id' value='{$id}'>
                      <button type='submit' class='btn btn-danger'>Sil</button>
                    </form>
                  </td>
                </tr>";
                    $counter++;
                }

                echo "</table>";

                if ($counter > 5) {
                    echo "<button id='toggleBooks' class='btn btn-secondary' style='margin-top:10px;'>Daha Fazla Göster</button>";
                }
                echo "<div style='margin-bottom: 40px;'></div>";
            } else {
                echo "<p>Henüz kitap yok.</p>";
            }

            ?>
        </div>


        <!-- Bölüm 3: Ödünç Alma İstekleri -->
        <div class="card">
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

            if ($resReq)
                $resReq->close();
            ?>
        </div>
        <!-- Bölüm 4: Onaylanmış ve iade bekleyenler -->
        <div class="card">
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

            if ($resApproved)
                $resApproved->close();
            ?>
        </div>
    </div>
    <script>
        const searchInput = document.getElementById("bookSearch");
        const resultsDiv = document.getElementById("bookResults");

        searchInput.addEventListener("input", async () => {
            const q = searchInput.value.trim();
            if (q.length < 3) {
                resultsDiv.style.display = "none";
                return;
            }

            try {
                const res = await fetch(
                    `https://www.googleapis.com/books/v1/volumes?q=${encodeURIComponent(q)}&maxResults=6`
                );
                const data = await res.json();

                resultsDiv.innerHTML = "";
                resultsDiv.style.display = "block";

                if (!data.items) {
                    resultsDiv.innerHTML = "<div style='padding:8px;'>Sonuç yok</div>";
                    return;
                }

                data.items.forEach(book => {
                    const info = book.volumeInfo || {};
                    const title = info.title || "";
                    const author = (info.authors || []).join(", ");
                    const category = (info.categories || [""])[0];
                    const isbn =
                        info.industryIdentifiers?.find(i => i.type === "ISBN_13")?.identifier ||
                        info.industryIdentifiers?.find(i => i.type === "ISBN_10")?.identifier ||
                        "";

                    const div = document.createElement("div");
                    div.style.padding = "8px";
                    div.style.cursor = "pointer";
                    div.style.borderBottom = "1px solid #eee";
                    div.innerHTML = `<strong>${title}</strong><br><small>${author}</small>`;

                    div.onclick = () => {
                        document.getElementById("title").value = title;
                        document.getElementById("author").value = author;
                        document.getElementById("category").value = category;
                        document.getElementById("isbn").value = isbn;

                        const coverUrl = isbn ? `https://covers.openlibrary.org/b/isbn/${isbn}-L.jpg` : "";
                        document.getElementById("cover_url").value = coverUrl;

                        const year = info.publishedDate ? parseInt(info.publishedDate.slice(0, 4)) : "";
                        document.getElementById("year").value = year;

                        resultsDiv.style.display = "none";
                        searchInput.value = "";
                    };

                    resultsDiv.appendChild(div);
                });

            } catch (err) {
                resultsDiv.innerHTML = "<div style='padding:8px;'>Hata oluştu</div>";
                resultsDiv.style.display = "block";
            }
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const toggleBtn = document.getElementById("toggleBooks");
            if (!toggleBtn) return;

            let expanded = false;
            toggleBtn.addEventListener("click", function () {
                const hiddenRows = document.querySelectorAll(".book-row.hidden");

                if (!expanded) {
                    hiddenRows.forEach(row => row.style.display = "table-row");
                    toggleBtn.textContent = "Daha Az Göster";
                    expanded = true;
                } else {
                    hiddenRows.forEach(row => row.style.display = "none");
                    toggleBtn.textContent = "Daha Fazla Göster";
                    expanded = false;
                }
            });
        });
    </script>
</body>

</html>