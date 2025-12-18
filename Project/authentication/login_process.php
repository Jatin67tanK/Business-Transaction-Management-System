<?php
session_start();
require '../db.php';

if (isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $pwd   = md5($_POST['pwd']); // Replace md5 later with password_hash()

    $query = "SELECT * FROM users WHERE email = '$email' AND password = '$pwd'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION["username"] = $row["username"];
        $_SESSION["email"]    = $row["email"];
        $_SESSION["role"]     = $row["role"];

        if ($row["role"] === 'admin') {
            header("Location: ../admin/admin_dashboard.php");
        } else {
            header("Location: ../user/user_dashboard.php");
        }
        exit();
    } else {
        $_SESSION['flash'] = '<div class="alert alert-danger mt-3">Invalid email or password.</div>';
        header("Location: ./login.php");
        exit();
    }
} else {
    header("Location: ./login.php");
    exit();
}
