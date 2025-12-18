<?php
session_start();
require '../db.php';

// Prevent signup if already logged in
if (isset($_SESSION['username'])) {
    unset($_SESSION['username']);
    // $_SESSION['flash'] = "<div class='alert alert-warning mt-3'>You are already logged in as " . htmlspecialchars($_SESSION['username']) . ". Please logout before creating a new account.</div>";
    // header("Location: ./signup.php");
    exit();
}

if (isset($_POST['signup'])) {
    $username = trim($_POST['username']);
    $email    = trim($_POST['email']);
    $pwd      = $_POST['password'];
    $cpwd     = $_POST['Cpassword'];
    $role     = 'user'; // default role on signup (you can allow admin if needed)

    // ✅ Password match check
    if ($pwd !== $cpwd) {
        $_SESSION['flash'] = "<div class='alert alert-danger mt-3'>⚠️ Confirm Password must match Password.</div>";
        header("Location: ./signup.php");
        exit();
    }

    // ✅ Check if email exists
    $check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    if ($check && mysqli_num_rows($check) > 0) {
        $_SESSION['flash'] = "<div class='alert alert-warning mt-3'>⚠️ Email already registered.</div>";
        header("Location: ./signup.php");
        exit();
    }

    // ✅ Check if username exists
    $checkUser = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
    if ($checkUser && mysqli_num_rows($checkUser) > 0) {
        $_SESSION['flash'] = "<div class='alert alert-warning mt-3'>⚠️ Username already taken.</div>";
        header("Location: ./signup.php");
        exit();
    }

    // ✅ Insert user
    $query = "INSERT INTO users (username, email, password, role) 
              VALUES ('$username', '$email', '".md5($pwd)."', '$role')";
    $result = mysqli_query($conn, $query);

    if ($result) {
        session_regenerate_id(true); // Security: regenerate session ID
        $_SESSION['flash'] = "<div class='alert alert-success mt-3'>✅ Account created! <a href='./login.php'>Login now</a></div>";
        header("Location: ./signup.php");
        exit();
    } else {
        $_SESSION['flash'] = "<div class='alert alert-danger mt-3'>❌ Signup failed. Please try again.</div>";
        header("Location: ./signup.php");
        exit();
    }
}
