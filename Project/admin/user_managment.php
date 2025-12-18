<?php
session_start();
include '../db.php';

// ✅ Only admins allowed
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../authentication/login.php");
    exit();
}

// ✅ Back button
if (isset($_POST['back'])) {
    header("Location: ./admin_dashboard.php");
    exit();
}

// ✅ Handle delete request
if (isset($_POST['delete'])) {
    $deleteId = $_POST['id'];
    $sql = "DELETE FROM users WHERE id = '$deleteId'";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('User deleted successfully!'); window.location.href='./user_managment.php';</script>";
        exit();
    } else {
        echo "Error deleting user: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Management</title>
  <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="./css/userManagement.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
  $(document).ready(function() {
      // ✅ Live Search AJAX
      $("#search").on("keyup", function(){
          var searchTerm = $(this).val().trim();
          $.ajax({
              url: 'fetch_record.php',
              type: 'POST',
              data: { search: searchTerm ,
                table: 'users'
              },
              success: function(response) {
                  $('.category-record').html(response);
              }
          });
      });
  });
  </script>
</head>

<body>
<div class="main-container">
    <?php include "../sidebar.php"; ?>

    <div class="dashboard">
        <div class="head-section">
            <div id="hamburger" class="hamburger">☰</div>
            <h3 class="logo">CashFlowX</h3>
            <div class="btn-section">
                <form method="post">
                    <button type="submit" class="btn btn-dark" name="back">Back</button>
                </form>
            </div>
        </div>

        <div class="form-container">
            <div class="category-container">
                <h2>User Manager</h2>
                <div class="search-section">
                    <input type="text" id="search" class="Search-bar" placeholder="Search users..." />
                </div>

                <div class="category-record">
                <hr>

                <?php
                $query = mysqli_query($conn, "SELECT * FROM users");
                if ($query && mysqli_num_rows($query) > 0) {
                    echo "<form method='POST' class='category-item table-head'>
                            <input type='text' value='ID' readonly>
                            <input type='text' value='Username' readonly>
                            <input type='text' value='Email' readonly>
                            <input type='text' value='Role' readonly>
                            <input type='text' value='Action' readonly>
                          </form>";

                    while ($row = mysqli_fetch_assoc($query)) {
                        echo "<form method='POST' class='category-item' onsubmit='return confirm(\"Are you sure?\");'>
                                <input type='text' name='id' value='{$row['id']}' readonly>
                                <input type='text' name='username' value='{$row['username']}' readonly>
                                <input type='text' name='email' value='{$row['email']}' readonly>
                                <input type='text' name='role' value='{$row['role']}' readonly>";
                        if ($row['role'] != 'admin') {
                            echo "<button type='submit' name='delete' class='btn btn-danger btn-sm'>Delete</button>";
                        }
                        echo "</form>";
                    }
                } else {
                    echo "<p>No users found.</p>";
                }
                ?>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
