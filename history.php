<?php
session_start();
require_once "db.php";
$conn = db();

$user_id = $_SESSION["user_id"] ?? 0;
$is_admin = !empty($_SESSION["is_admin"]);

if ($user_id === 0 && !$is_admin) {
    header("Location: login.php");
    exit;
}

// Build query depending on role
if ($is_admin) {
    // Admin sees ALL history with User names
    $query = "
        SELECT br.id, u.fullname as user_name, b.title, b.author, br.borrow_date, br.due_date, br.return_date, br.status
        FROM borrowings br
        JOIN books b ON br.book_id = b.id
        JOIN users u ON br.user_id = u.id
        ORDER BY br.borrow_date DESC
    ";
} else {
    // Regular user sees ONLY their history
    $query = "
        SELECT br.id, b.title, b.author, br.borrow_date, br.due_date, br.return_date, br.status
        FROM borrowings br
        JOIN books b ON br.book_id = b.id
        WHERE br.user_id = $user_id
        ORDER BY br.borrow_date DESC
    ";
}

$result = $conn->query($query);
if (!$result)
    die("Query failed: " . $conn->error);
?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="styles.css?v=<?php echo time(); ?>">
    <meta charset="UTF-8">
    <title>Borrowing History</title>
</head>

<body class="theme-library">

    <div class="navbar">
        <!-- Logo Left -->
        <a href="index.php">
            <img src="logo.png" alt="Logo" class="nav-logo">
        </a>

        <!-- Links Center -->
        <div class="nav-links">
            <a class="btn btn-primary" href="index.php">Home</a>
            <a class="btn btn-primary" href="dashboard.php">Dashboard</a>
            <a class="btn btn-primary" href="history.php">History</a>
            <?php if ($is_admin): ?>
                <a class="btn btn-primary" href="admin.php">Admin Panel</a>
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
        <h1><?= $is_admin ? "All Borrowing History (Admin View)" : "My Borrowing History" ?></h1>

        <div style="overflow-x:auto;">
            <table id="historyTable">
                <thead>
                    <tr>
                        <?php if ($is_admin): ?>
                            <th>User</th>
                        <?php endif; ?>
                        <th>Book Title</th>
                        <th>Author</th>
                        <th>Borrow Date</th>
                        <th>Due Date</th>
                        <th>Return Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr data-status="<?php echo $row['status']; ?>">
                            <?php if ($is_admin): ?>
                                <td><?php echo htmlspecialchars($row['user_name']); ?></td>
                            <?php endif; ?>
                            <td><?php echo htmlspecialchars($row['title']); ?></td>
                            <td><?php echo htmlspecialchars($row['author']); ?></td>
                            <td><?php echo $row['borrow_date']; ?></td>
                            <td><?php echo $row['due_date']; ?></td>
                            <td><?php echo $row['return_date'] ?: '-'; ?></td>
                            <td class="status"><?php echo ucfirst($row['status']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <?php if ($result->num_rows == 0): ?>
            <p style="text-align:center; padding:20px;">No history records found.</p>
        <?php endif; ?>
    </div>

    <script>
        // Status colorization
        const rows = document.querySelectorAll('#historyTable tr[data-status]');
        rows.forEach(tr => {
            const status = tr.dataset.status;
            // .status class is on the last td
            const td = tr.querySelector('.status');
            if (td && status) {
                td.className = 'status status-' + status; // e.g. status-approved
            }
        });
    </script>
</body>

</html>
<?php
$result->close();
$conn->close();
?>