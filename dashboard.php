<?php
session_start();
require_once "db.php";
$conn = db();

$user_id = $_SESSION["user_id"] ?? 0;
$is_admin = !empty($_SESSION["is_admin"]);

// If not logged in as user OR admin, redirect to login
if ($user_id === 0 && !$is_admin) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $is_admin ? 'Admin Dashboard' : 'User Dashboard' ?></title>
    <link rel="stylesheet" href="styles.css?v=<?php echo time(); ?>">
    <link rel="icon" href="images/favicon.ico" type="image/x-icon">
 
</head>

<body class="theme-library">

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

        <?php if ($is_admin): ?>
            <!-- ADMIN DASHBOARD VIEW -->
            <div class="container">
                <h1>Admin Dashboard</h1>

                <div style="margin-bottom: 20px; text-align: center;">
                    <h2>Welcome, <?php echo htmlspecialchars($_SESSION['admin_name'] ?? 'Admin'); ?>!</h2>
                </div>

                <div style="display: flex; gap: 20px; justify-content: center; flex-wrap: wrap; margin-bottom: 30px;">
                    <?php
                    // 1. Total Books
                    $resTotal = $conn->query("SELECT COUNT(*) as c FROM books");
                    $totalBooks = $resTotal->fetch_assoc()['c'] ?? 0;

                    // 2. Currently Borrowed (Approved)
                    $resBorrowed = $conn->query("SELECT COUNT(*) as c FROM borrowings WHERE status = 'approved'");
                    $borrowedCount = $resBorrowed->fetch_assoc()['c'] ?? 0;

                    // 3. Pending Requests
                    $resPending = $conn->query("SELECT COUNT(*) as c FROM borrowings WHERE status = 'pending'");
                    $pendingCount = $resPending->fetch_assoc()['c'] ?? 0;
                    ?>

                    <div class="card"
                        style="flex: 1; min-width: 200px; text-align: center; background: #fffdf8; border: 1px solid #d8cfbf;">
                        <h2 style="color: #4b2a2a; margin-bottom: 5px;"><?= $totalBooks ?></h2>
                        <p style="margin: 0; color: #666;">Total Books</p>
                    </div>

                    <div class="card"
                        style="flex: 1; min-width: 200px; text-align: center; background: #fffdf8; border: 1px solid #d8cfbf;">
                        <h2 style="color: #2980b9; margin-bottom: 5px;"><?= $borrowedCount ?></h2>
                        <p style="margin: 0; color: #666;">Currently Borrowed</p>
                    </div>

                    <div class="card"
                        style="flex: 1; min-width: 200px; text-align: center; background: #fffdf8; border: 1px solid #d8cfbf;">
                        <h2 style="color: #f39c12; margin-bottom: 5px;"><?= $pendingCount ?></h2>
                        <p style="margin: 0; color: #666;">Pending Requests</p>
                    </div>
                </div>

                <div class="card">
                    <h3>Who Borrowed What? (Active Loans)</h3>
                    <?php
                    // Get all active loans (approved)
                    $q = "
                  SELECT br.id, br.borrow_date, br.due_date, br.status, u.fullname, b.title
                  FROM borrowings br
                  JOIN users u ON br.user_id = u.id
                  JOIN books b ON br.book_id = b.id
                  WHERE br.status = 'approved'
                  ORDER BY br.borrow_date DESC
                ";
                    $res = $conn->query($q);
                    ?>
                    <?php if ($res && $res->num_rows > 0): ?>
                        <table>
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Book Title</th>
                                    <th>Borrowed On</th>
                                    <th>Due Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $res->fetch_assoc()): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($row['fullname']) ?></td>
                                        <td><?= htmlspecialchars($row['title']) ?></td>
                                        <td><?= $row['borrow_date'] ?></td>
                                        <td><?= $row['due_date'] ?></td>
                                        <td>
                                            <span class="status-approved">Active</span>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p>No active loans at the moment.</p>
                    <?php endif; ?>
                </div>

                <div class="card" style="margin-top:20px;">
                    <h3>Overdue Books</h3>
                    <?php
                    // Simple overdue check
                    $q2 = "
                  SELECT br.due_date, u.fullname, b.title
                  FROM borrowings br
                  JOIN users u ON br.user_id = u.id
                  JOIN books b ON br.book_id = b.id
                  WHERE br.status = 'approved' AND br.due_date < CURDATE()
                ";
                    $res2 = $conn->query($q2);
                    ?>
                    <?php if ($res2 && $res2->num_rows > 0): ?>
                        <table>
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Book</th>
                                    <th>Due Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row2 = $res2->fetch_assoc()): ?>
                                    <tr style="background:#ffe9e9;">
                                        <td><?= htmlspecialchars($row2['fullname']) ?></td>
                                        <td><?= htmlspecialchars($row2['title']) ?></td>
                                        <td style="color:red; font-weight:bold;"><?= $row2['due_date'] ?></td>
                                        <td style="color:red;">OVERDUE</td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p style="color:green;">No overdue books.</p>
                    <?php endif; ?>
                </div>

                <div style="text-align:center; margin-top:20px;">
                    <a class="btn btn-primary" href="admin.php">Go to Full Admin Panel &raquo;</a>
                </div>
            </div>

        <?php else: ?>
            <!-- USER DASHBOARD VIEW -->
            <div class="card-container">

                <div style="margin-bottom: 20px; text-align: center;">
                    <h2>Welcome, <?php echo htmlspecialchars($_SESSION['fullname'] ?? 'User'); ?>!</h2>
                </div>

                <div style="display: flex; gap: 20px; justify-content: center; flex-wrap: wrap; margin-bottom: 30px;">
                    <?php
                    // 1. Total Books (Library-wide)
                    $resTotal = $conn->query("SELECT COUNT(*) as c FROM books");
                    $totalBooks = $resTotal->fetch_assoc()['c'] ?? 0;

                    // 2. My Borrowed (Approved)
                    $stmt1 = $conn->prepare("SELECT COUNT(*) as c FROM borrowings WHERE user_id = ? AND status = 'approved'");
                    $stmt1->bind_param("i", $user_id);
                    $stmt1->execute();
                    $borrowedCount = $stmt1->get_result()->fetch_assoc()['c'] ?? 0;

                    // 3. My Pending Requests
                    $stmt2 = $conn->prepare("SELECT COUNT(*) as c FROM borrowings WHERE user_id = ? AND status = 'pending'");
                    $stmt2->bind_param("i", $user_id);
                    $stmt2->execute();
                    $pendingCount = $stmt2->get_result()->fetch_assoc()['c'] ?? 0;
                    ?>

                    <div class="card"
                        style="flex: 1; min-width: 200px; text-align: center; background: #fffdf8; border: 1px solid #d8cfbf;">
                        <h2 style="color: #4b2a2a; margin-bottom: 5px;"><?= $totalBooks ?></h2>
                        <p style="margin: 0; color: #666;">Total Books in Library</p>
                    </div>

                    <div class="card"
                        style="flex: 1; min-width: 200px; text-align: center; background: #fffdf8; border: 1px solid #d8cfbf;">
                        <h2 style="color: #2980b9; margin-bottom: 5px;"><?= $borrowedCount ?></h2>
                        <p style="margin: 0; color: #666;">My Active Books</p>
                    </div>

                    <div class="card"
                        style="flex: 1; min-width: 200px; text-align: center; background: #fffdf8; border: 1px solid #d8cfbf;">
                        <h2 style="color: #f39c12; margin-bottom: 5px;"><?= $pendingCount ?></h2>
                        <p style="margin: 0; color: #666;">My Pending Requests</p>
                    </div>
                </div>

                <div class="card">
                    <h3>My Active Books</h3>
                    <div id="activeBooksList">
                        <!-- JS wil load this -->
                    </div>
                </div>

                <div class="card">
                    <h3>Upcoming Due Dates</h3>
                    <div id="dueDatesList">
                        <!-- JS will load this -->
                    </div>
                </div>

            </div>

            <script src="dashboard.js?v=<?php echo time(); ?>"></script>
        <?php endif; ?>
    </body>

</html>