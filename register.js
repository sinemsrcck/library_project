document.getElementById("registerForm").addEventListener("submit", function(e) { //phpden registerForm bulur, register basıldığında bunu yap.
  const email = document.getElementById("email").value.trim(); //E mail inputundaki değeri aldırdım.
  const password = document.getElementById("password").value;
  const confirmPassword = document.getElementById("confirmPassword").value;
  const error = document.getElementById("errorMessage"); //Hata mesajını aldım.

  error.innerText = "";

  if (!email.includes("@")) { //Formu göndermez.
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

  
});
