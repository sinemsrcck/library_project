<?php
session_start();
require_once "db.php";
$conn = db();

$user_id = $_SESSION["user_id"] ?? $_SESSION["admin_id"] ?? 0;

if ($user_id === 0) {
    header("Location: login.php");
    exit;
}

$msg = "";
$msgType = "";

// Handle Password Change
if (isset($_POST['change_password'])) {
    $current_pass = $_POST['current_password'] ?? '';
    $new_pass = $_POST['new_password'] ?? '';
    $confirm_pass = $_POST['confirm_password'] ?? '';

    // Verify current password
    $stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $res = $stmt->get_result();
    $row = $res->fetch_assoc();

    if ($row && password_verify($current_pass, $row['password'])) {
        if ($new_pass === $confirm_pass && !empty($new_pass)) {
            $new_hash = password_hash($new_pass, PASSWORD_DEFAULT);
            $upd = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
            $upd->bind_param("si", $new_hash, $user_id);
            if ($upd->execute()) {
                $msg = "Password updated successfully!";
                $msgType = "success";
            } else {
                $msg = "Error updating password.";
                $msgType = "error";
            }
        } else {
            $msg = "New passwords do not match or are empty.";
            $msgType = "error";
        }
    } else {
        $msg = "Incorrect current password.";
        $msgType = "error";
    }
}

// Fetch User Info
$stmt = $conn->prepare("SELECT fullname, email, role FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

$is_admin = ($user['role'] === 'admin');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>My Profile</title>
    <link rel="stylesheet" href="styles.css?v=<?php echo time(); ?>">
    <style>
        .profile-container {
            max-width: 600px;
            margin: 40px auto;
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .profile-info p {
            font-size: 16px;
            margin: 10px 0;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }

        .profile-info strong {
            width: 150px;
            display: inline-block;
            color: #555;
        }
    </style>
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

    <div class="profile-container">
        <h1>My Profile</h1>

        <div class="profile-info">
            <p><strong>Full Name:</strong> <?= htmlspecialchars($user['fullname']) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
            <p><strong>Role:</strong> <?= ucfirst($user['role']) ?></p>
            
        </div>

        <hr style="margin: 30px 0;">

        <h3>Change Password</h3>

        <?php if ($msg): ?>
            <div class="<?= $msgType === 'success' ? 'msg-success' : 'msg-error' ?>" style="margin-bottom:15px;">
                <?= $msg ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="profile.php">
            <label>Current Password</label>
            <input type="password" name="current_password" required>

            <label>New Password</label>
            <input type="password" name="new_password" required>

            <label>Confirm New Password</label>
            <input type="password" name="confirm_password" required>

            <button type="submit" name="change_password" class="btn btn-primary" style="margin-top: 10px;">Update
                Password</button>
        </form>
    </div>

</body>

</html>