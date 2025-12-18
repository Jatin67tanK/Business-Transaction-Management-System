<?php
session_start();
include "./db.php";

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    // HTML validation fallback
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || empty($username)) {
        header("Location: profile.php?error=1");
        exit;
    }

    // Fetch current details from DB
    $queryCheck = "SELECT username, email, role FROM users WHERE id='$id' LIMIT 1";
    $result = mysqli_query($conn, $queryCheck);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Check if submitted values are the same as DB
        if ($row['username'] === $username && $row['email'] === $email && $row['role'] === $role) {
            header("Location: profile.php?nochange=1");
            exit;
        }
    }
    $query = "UPDATE users SET username='$username', email='$email' WHERE id='$id'";
    if (mysqli_query($conn, $query)) {
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $role;
        header("Location: profile.php?success=1");
        exit;
    } else {
        header("Location: profile.php?error=1");
        exit;
    }
}
?>
