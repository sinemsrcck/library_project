<?php
session_start();
require_once "db.php";
$conn = db();


$errorMessage = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

   $loginType = $_POST["login_type"] ?? "user";
  $email = trim($_POST["email"] ?? "");
  $password = $_POST["password"] ?? "";

  if ($email === "" || $password === "") {
    $errorMessage = "Please fill in all fields.";
  } else {

    // Tek sorgu: kullanıcıyı + rolünü çek
    $stmt = $conn->prepare("SELECT id, fullname, password, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {

      $stmt->bind_result($id, $fullname, $hashedPassword, $role);
      $stmt->fetch();

      if (password_verify($password, $hashedPassword)) {

        // Admin seçtiyse ama DB'de admin değilse -> reddet
        if ($loginType === "admin" && $role !== "admin") {
          $errorMessage = "This account is not an admin.";
        } else {

          if ($role === "admin") {
            $_SESSION["is_admin"] = 1;
            $_SESSION["admin_id"] = $id;
            $_SESSION["admin_name"] = $fullname;
            header("Location: admin.php");
            exit;
          } else {
            unset($_SESSION["is_admin"]);
            $_SESSION["user_id"] = $id;
            $_SESSION["fullname"] = $fullname;
            $_SESSION["email"] = $email;
            header("Location: dashboard.php");
            exit;
          }
        }

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
    <link rel="icon" href="images/favicon.ico" type="image/x-icon">
</head>
<body class="auth-page theme-library">

<div class="container">

    <div class="login-top-image">
    <img src="images/giris.png" alt="Login Icon">
</div>


    <form id="loginForm" class="form-box" method="POST">
      
        <div style="display:flex; gap:10px; margin-bottom:20px; justify-content:center;">
  <button type="button" class="btn btn-success" id="userBtn">User</button>
  <button type="button" class="btn btn-primary" id="adminBtn">Admin</button>
</div>

<input type="hidden" name="login_type" id="loginType" value="user">


        <label>Email</label>
        <input type="email" name="email" id="emailInput" placeholder="example@mail.com" required>

        <label>Password</label>
        <input type="password" name="password" id="passwordInput" placeholder="Enter password" required>

        <button type="submit">Login</button>

        <?php if ($errorMessage): ?>
            <p style="color:red; margin-top:10px;">
                <?php echo htmlspecialchars($errorMessage); ?>
            </p>
        <?php endif; ?>

        <div id="registerLink">
  <p class="small-text">
    Don’t have an account?
    <a href="register.php">Register</a>
  </p>
</div>
    </form>
    <script>
  const loginTypeInput = document.getElementById("loginType");
  const userBtn = document.getElementById("userBtn");
  const adminBtn = document.getElementById("adminBtn");

  const emailInput = document.getElementById("emailInput");
  const registerLink = document.getElementById("registerLink");

  // USER seçimi (default)
  userBtn.addEventListener("click", () => {
    loginTypeInput.value = "user";

    userBtn.classList.add("btn-success");
    userBtn.classList.remove("btn-primary");

    adminBtn.classList.add("btn-primary");
    adminBtn.classList.remove("btn-success");

    emailInput.placeholder = "User email";
    registerLink.style.display = "block";
  });

  // ADMIN seçimi
  adminBtn.addEventListener("click", () => {
    loginTypeInput.value = "admin";

    adminBtn.classList.add("btn-success");
    adminBtn.classList.remove("btn-primary");

    userBtn.classList.add("btn-primary");
    userBtn.classList.remove("btn-success");

    emailInput.placeholder = "Admin email";
    registerLink.style.display = "none";
  });
</script>


</div>

</body>
</html>
