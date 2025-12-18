document.getElementById("signupForm").addEventListener("submit", function(event) {
    let valid = true;

    // Regex Patterns
    const usernamePattern = /^[A-Za-z0-9_]{3,15}$/;
    const emailPattern = /^[a-zA-Z0-9._%+-]+@gmail\.com$/;
    const passwordPattern = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d@$!%*#?&]{6,}$/;

    // Inputs
    const username = document.getElementById("username").value.trim();
    const email = document.getElementById("email").value.trim();
    const pwd = document.getElementById("pwd").value.trim();
    const cpwd = document.getElementById("cpwd").value.trim();
    const role = document.getElementById("role").value;

    // Error Divs
    const usernameError = document.getElementById("usernameError");
    const emailError = document.getElementById("emailError");
    const pwdError = document.getElementById("pwdError");
    const cpwdError = document.getElementById("cpwdError");
    const roleError = document.getElementById("roleError");

    // Reset messages
    usernameError.textContent = "";
    emailError.textContent = "";
    pwdError.textContent = "";
    cpwdError.textContent = "";
    roleError.textContent = "";

    // Username
    if (!usernamePattern.test(username)) {
        usernameError.textContent = "3–15 chars, letters/numbers/underscore only.";
        valid = false;
    }

    // Email
    if (!emailPattern.test(email)) {
        emailError.textContent = "Enter a valid Gmail address.";
        valid = false;
    }

    // Password
    if (!passwordPattern.test(pwd)) {
        pwdError.textContent = "At least 6 chars, include 1 letter & 1 number.";
        valid = false;
    }

    // Confirm Password
    if (pwd !== cpwd) {
        cpwdError.textContent = "Passwords do not match.";
        valid = false;
    }

    // Role
    if (!role) {
        roleError.textContent = "Please select a role.";
        valid = false;
    }

    if (!valid) event.preventDefault();
});
