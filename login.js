document.getElementById("loginForm").addEventListener("submit", function(e) {
    let email = document.getElementById("email").value.trim();
    let password = document.getElementById("password").value.trim();

    if (email === "" || password === "") {
        alert("Email and password cannot be empty.");
        e.preventDefault();
    }
});
