document.getElementById("registerForm").addEventListener("submit", function(e) {
  e.preventDefault();

  const email = document.getElementById("email").value;
  const password = document.getElementById("password").value;
  const confirmPassword = document.getElementById("confirmPassword").value;
  const error = document.getElementById("errorMessage");

  if (!email.includes("@")) {
    error.innerText = "Invalid email address!";
    return;
  }

  if (password.length < 6) {
    error.innerText = "Password must be at least 6 characters!";
    return;
  }

  if (password !== confirmPassword) {
    error.innerText = "Passwords do not match!";
    return;
  }

  alert("Registration successful!");
  error.innerText = "";
});

