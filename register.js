document.getElementById("registerForm").addEventListener("submit", function(e) {
  const email = document.getElementById("email").value.trim();
  const password = document.getElementById("password").value;
  const confirmPassword = document.getElementById("confirmPassword").value;
  const error = document.getElementById("errorMessage");

  error.innerText = "";

  if (!email.includes("@")) {
    e.preventDefault();
    error.innerText = "Invalid email address!";
    return;
  }

  if (password.length < 6) {
    e.preventDefault();
    error.innerText = "Password must be at least 6 characters!";
    return;
  }

  if (password !== confirmPassword) {
    e.preventDefault();
    error.innerText = "Passwords do not match!";
    return;
  }

  // ✅ Burada preventDefault YOK -> form PHP'ye gidecek ve DB'ye kayıt atılacak.
});
