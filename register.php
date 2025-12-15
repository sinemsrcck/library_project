<?php
// Hata mesajı için değişken
$errorMessage = "";

// Form gönderildiyse
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $fullname = trim($_POST["fullname"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirmPassword"];

    // Şifreler eşleşiyor mu?
    if ($password !== $confirmPassword) {
        $errorMessage = "Passwords do not match!";
    } else {

        // Veritabanı bağlantısı
        $conn = new mysqli("localhost", "root", "", "your_database_name");

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Şifreyi hashle
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Email daha önce var mı?
        $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            $errorMessage = "This email is already registered.";
        } else {

            // Kullanıcıyı ekle
            $stmt = $conn->prepare(
                "INSERT INTO users (fullname, email, password) VALUES (?, ?, ?)"
            );
            $stmt->bind_param("sss", $fullname, $email, $hashedPassword);

            if ($stmt->execute()) {
                header("Location: login.php"); // kayıt başarılı
                exit();
            } else {
                $errorMessage = "Registration failed!";
            }
        }

        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register</title>
  <link rel="stylesheet" href="register.css">
</head>
<body class="auth-page">

<div class="register-box">
  <h2>Create Account</h2>

  <form method="POST" action="">
    <input type="text" name="fullname" placeholder="Full Name" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <input type="password" name="confirmPassword" placeholder="Confirm Password" required>

    <button type="submit">Register</button>

    <?php if ($errorMessage): ?>
      <p id="errorMessage"><?php echo $errorMessage; ?></p>
    <?php endif; ?>
  </form>
</div>

</body>
</html>

