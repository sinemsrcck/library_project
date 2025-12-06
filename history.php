<?php
session_start();
require_once 'login.php';

// Veritabanına bağlan
$conn = new mysqli($hn, $un, $pw, $db);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

// Şimdilik test için user_id = 1
$user_id = 1;

// Borrowing kayıtlarını çek
$query = "
    SELECT b.title, b.author, br.borrow_date, br.due_date, br.return_date, br.status
    FROM borrowings br
    JOIN books b ON br.book_id = b.id
    WHERE br.user_id = $user_id
    ORDER BY br.borrow_date DESC
";

$result = $conn->query($query);
if (!$result) die("Query failed: " . $conn->error);
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="styles.css">
    <meta charset="UTF-8">
    <title>Borrowing History</title>
    
</head>
<body>
    <div class="container">

    <h1>Borrowing History</h1>

    <div class="card">
    <table id="historyTable">
        <tr>
            <th>Book Title</th>
            <th>Author</th>
            <th>Borrow Date</th>
           th>Due Date</th>
            <th>Return Date</th>
            <th>Status</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr data-status="<?php echo $row['status']; ?>">
                <td><?php echo htmlspecialchars($row['title']); ?></td>
                <td><?php echo htmlspecialchars($row['author']); ?></td>
                <td><?php echo $row['borrow_date']; ?></td>
                <td><?php echo $row['due_date']; ?></td>
                <td><?php echo $row['return_date'] ?: '-'; ?></td>
                <td class="status"><?php echo $row['status']; ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
    </div>
</div>
    <script>
        // Status renklendirme
        const rows = document.querySelectorAll('#historyTable tr[data-status]');
        rows.forEach(tr => {
            const status = tr.dataset.status;
            const td = tr.querySelector('.status');
            td.classList.add('status-' + status);
        });
    </script>
</body>
</html>
<?php
$result->close();
$conn->close();
?>
