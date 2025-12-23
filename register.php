<?php
session_start();//Bilgileri tutmak için.
require_once "db.php";
$conn = db();

// ----------------------------
// REGISTER PHP LOGIC
// ----------------------------
$errorMessage = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {//Form postla gönderildi mi.Bilgiler geldi mi?

    $fullname = trim($_POST["fullname"] ?? "");
    $email = trim($_POST["email"] ?? "");//Verileri aldım
    $password = $_POST["password"] ?? "";
    $confirmPassword = $_POST["confirmPassword"] ?? "";

    if ($password !== $confirmPassword) {
        $errorMessage = "Passwords do not match!";
    } else {

        $conn = db();

        // Email kontrol
        $check = $conn->prepare("SELECT id FROM users WHERE email = ?");//Daha önce mail var mı?
        $check->bind_param("s", $email); //hangi değişken hangi tür?
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {//kayıtlı satır varsa engelledim.
            $errorMessage = "This email is already registered.";
        } else {

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $conn->prepare( //Yeni eklemek için hazırlandım.
            "INSERT INTO users (fullname, email, password, role) VALUES (?, ?, ?, 'user')"
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
  <link rel="icon" href="images/favicon.ico" type="image/x-icon">
</head>
<body class="theme-library">


<div class="register-box">
  <h2>Create Account</h2>

  <form id="registerForm" method="POST" action="">
    <input type="text" name="fullname" id="fullname" placeholder="Full Name" required>
    <input type="email" name="email" id="email" placeholder="Email" required>
    <input type="password" name="password" id="password" placeholder="Password" required>
    <input type="password" name="confirmPassword" id="confirmPassword" placeholder="Confirm Password" required>

    <button type="submit">Register</button>

    <p class="small-text">
    Already have an account?
     <a href="login.php">Login</a>
   </p>

    <p id="errorMessage"><!-- Php den gelen hata.-->
      <?php if ($errorMessage) echo htmlspecialchars($errorMessage); ?>
    </p>
  </form>
</div>

<!-- JS AYRI DOSYA, AYNI KALIYOR -->
<script src="register.js"></script>

</body>
</html>
