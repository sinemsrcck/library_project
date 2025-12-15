<?php
session_start();
require_once "db.php";
$conn = db();

// ----------------------------
// REGISTER PHP LOGIC
// ----------------------------
$errorMessage = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $fullname = trim($_POST["fullname"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";
    $confirmPassword = $_POST["confirmPassword"] ?? "";

    if ($password !== $confirmPassword) {
        $errorMessage = "Passwords do not match!";
    } else {

        $conn = db();


        if ($conn->connect_error) {
            die("Connection failed");
        }

        // Email kontrol
        $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            $errorMessage = "This email is already registered.";
        } else {

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $conn->prepare(
                "INSERT INTO users (fullname, email, password) VALUES (?, ?, ?)"
            );
            $stmt->bind_param("sss", $fullname, $email, $hashedPassword);

            if ($stmt->execute()) {
                header("Location: login.php");
                exit;
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
  <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="register-box">
  <h2>Create Account</h2>

  <form id="registerForm" method="POST" action="">
    <input type="text" name="fullname" id="fullname" placeholder="Full Name" required>
    <input type="email" name="email" id="email" placeholder="Email" required>
    <input type="password" name="password" id="password" placeholder="Password" required>
    <input type="password" name="confirmPassword" id="confirmPassword" placeholder="Confirm Password" required>

    <button type="submit">Register</button>

    <p id="errorMessage">
      <?php if ($errorMessage) echo htmlspecialchars($errorMessage); ?>
    </p>
  </form>
</div>

<!-- JS AYRI DOSYA, AYNI KALIYOR -->
<script src="register.js"></script>

</body>
</html>
