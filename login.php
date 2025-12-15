<?php
session_start();
require_once "config.php";

$errorMessage = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";

    if ($email === "" || $password === "") {
        $errorMessage = "Please fill in all fields.";
    } else {

        // Veritabanı bağlantısı
        $conn = new mysqli($hn, $un, $pw, $db);

        if ($conn->connect_error) {
            die("Database connection failed");
        }

        // Kullanıcıyı email ile bul
        $stmt = $conn->prepare(
            "SELECT id, fullname, password FROM users WHERE email = ?"
        );
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 1) {

            $stmt->bind_result($id, $fullname, $hashedPassword);
            $stmt->fetch();

            // Şifre doğrulama
            if (password_verify($password, $hashedPassword)) {

                // Session oluştur
                $_SESSION["user_id"] = $id;
                $_SESSION["fullname"] = $fullname;
                $_SESSION["email"] = $email;

                header("Location: dashboard.php");
                exit;

            } else {
                $errorMessage = "Incorrect password.";
            }

        } else {
            $errorMessage = "User not found.";
        }

        $stmt->close();
        $conn->close();
    }
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
<body class="auth-page">

<div class="container">
    <form class="form-box" method="POST" action="">
        <h2>Login</h2>

        <label>Email</label>
        <input type="email" name="email" placeholder="example@mail.com" required>

        <label>Password</label>
        <input type="password" name="password" placeholder="Enter password" required>

        <button type="submit">Login</button>

        <?php if ($errorMessage): ?>
            <p style="color:red; margin-top:10px;">
                <?php echo htmlspecialchars($errorMessage); ?>
            </p>
        <?php endif; ?>

        <p class="small-text">
            Don’t have an account?
            <a href="register.php">Register</a>
        </p>
    </form>
</div>

</body>
</html>