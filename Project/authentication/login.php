<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>🔐 Login</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/loginStyle.css">
</head>
<body>

<div class="container justify-content-center align-items-center" style="min-height: 100vh;">
  <a href="../index.php" class="logo" style="text-decoration:none;">CashFlowX</a>
  <div class="login-card">
    <div class="img-section">
      <img src="../assets/img/enf-slider.png" alt="">
    </div>
    <div class="login-form-section">
      <h1 class="text-center login-title">Login</h1>

      <?php
      if (isset($_SESSION['flash'])) {
        echo $_SESSION['flash'];
        unset($_SESSION['flash']);
      }
      ?>

      <form method="POST" action="./login_process.php" autocomplete="off" id="loginForm">
        <div class="mb-3">
          <input type="email" id="email" name="email" placeholder="Enter Email" class="form-control" required>
          <div id="emailError" class="error-msg"></div>
        </div>
        <div class="mb-3">
          <input type="password" id="pwd" name="pwd" placeholder="Enter Password" class="form-control" required>
          <div id="pwdError" class="error-msg"></div>
        </div>
        <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
      </form>

      <div class="text-center mt-3">
        <a href="signup.php">Don't have an account? Sign Up</a>
      </div>
    </div>
  </div>
</div>

<script>
document.getElementById("loginForm").addEventListener("submit", function(event) {
  const email = document.getElementById("email").value.trim();
  const pwd = document.getElementById("pwd").value.trim();
  const emailError = document.getElementById("emailError");
  const pwdError = document.getElementById("pwdError");
  emailError.textContent = "";
  pwdError.textContent = "";

  let valid = true;
  const emailPattern = /^[a-zA-Z0-9._%+-]+@gmail\.com$/;
  const passwordPattern = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d@$!%*#?&]{6,}$/;

  if (!emailPattern.test(email)) {
    emailError.textContent = "Enter a valid Gmail address.";
    valid = false;
  }

  if (!passwordPattern.test(pwd)) {
    pwdError.textContent = "Password must have 6+ chars, 1 letter & 1 number.";
    valid = false;
  }

  if (!valid) event.preventDefault();
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
