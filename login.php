<?php
// ====== DATABASE CONNECTION ======
$$hn = "127.0.0.1";   // veya "localhost" (ikisinden biri)
$un = "root";        // MySQL'e Workbench ile bağlanırken kullandığın kullanıcı adı
$pw = "1395";        // MySQL şifren (varsa buraya yaz, yoksa boş bırak)
$db = "library_db";  // az önce tabloları oluşturduğun veritabanı

$conn = new mysqli($hn, $un, $pw, $db);
if ($conn->connect_error) {
    die("Database connection failed");
}

// ====== LOGIN LOGIC ======
session_start();
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user["password"])) {
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["role"] = $user["role"];
            header("Location: dashboard.php");
            exit;
        }
    }

    $error = "Invalid email or password";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Digital Library</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="container">
    <form class="form-box" id="loginForm" action="login.php" method="POST">
        <h2>Login</h2>

        <?php if ($error): ?>
            <p style="color:red; text-align:center;">
                <?= $error ?>
            </p>
        <?php endif; ?>

        <label>Email</label>
        <input type="text" id="email" name="email" placeholder="example@mail.com" required>

        <label>Password</label>
        <input type="password" id="password" name="password" placeholder="Enter password" required>

        <button type="submit">Login</button>

        <p class="small-text">Don’t have an account?
            <a href="register.php">Register</a>
        </p>
    </form>
</div>

<script src="login.js"></script>
</body>
</html>
