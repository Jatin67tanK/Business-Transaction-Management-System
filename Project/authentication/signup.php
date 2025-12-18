<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>📝 Sign Up</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="../assets/css/signinstyle.css">
</head>
<body>

<div class="container justify-content-center align-items-center" style="min-height: 100vh;">
  <div class="logo">CashFlowX</div>
  <div class="signup-card">
    <div class="img-section">
      <img src="../assets/img/enf-slider.png" alt="">
    </div>
    <div class="sign-form-section">
      <h3 class="text-center signup-title ">Create Account</h3>

      <!-- Flash Messages -->
      <?php
        if (isset($_SESSION['flash'])) {
            echo $_SESSION['flash'];
            unset($_SESSION['flash']); // show once
        }
      ?>

      <form method="POST" action="./signin_process.php" id="signupForm">
        <div class="mb-3">
          <input type="text" name="username" id="username" placeholder="Enter Username" class="form-control" required>
          <div id="usernameError" class="error-msg"></div>
        </div>
        <div class="mb-3">
          <input type="email" name="email" id="email" placeholder="Enter Email" class="form-control" required>
          <div id="emailError" class="error-msg"></div>
        </div>
        <div class="mb-3">
          <input type="password" name="password" id="pwd" placeholder="Enter Password" class="form-control" required>
          <div id="pwdError" class="error-msg"></div>
        </div>
        <div class="mb-3">
          <input type="password" name="Cpassword" id="cpwd" placeholder="Confirm Password" class="form-control" required>
          <div id="cpwdError" class="error-msg"></div>
        </div>
        <button type="submit" name="signup" class="btn btn-primary w-100">Sign Up</button>
      </form>

      <div class="text-center mt-3">
        <a href="login.php">Already have an account? Login</a>
      </div>
    </div>
  </div>
</div>

<!-- JS -->
<script src="../assets/js/signin_validation.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
          