<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] != 'user') {
    header("Location: /project/authentication/login.php");
    exit();
}
include "../db.php";
include "../authentication/logout.php";


include "../functions.php"; 

$totalIncome = getTotalIncome($conn);
$totalExpense = getTotalExpense($conn);
$netProfit = getNetProfit($conn);
$monthlyGrowth = getMonthlyGrowth($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Dashboard</title>
        <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="./css/accountant.css">
</head>
<style> 
  

.btn-section{
    display: flex;
    gap: 10px;
}

.btn-section .btns {
    background-color: #3e6ad9 !important;
    color: #ffffff !important;
    border: none;
    font-weight: 500;
    padding: 10px 15px;
    border-radius: 8px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.btn-section .btns:hover {
    background-color: #223975;
    color: #ffffff;
}
</style>
<body>
         <div class="main-container">
    <!-- Sidebar -->
                <?php include "../sidebar.php"; ?>

    <!-- Dashboard Section -->
    <div class="dashboard">
            <!-- Header -->
            <div class="head-section">
              <div id="hamburger" class="hamburger"> ☰ </div>

        <div class="logo">Accountant Panel</div>
        <div class="btn-section">
          <!-- <button class="btn btn-outline-dark">Search</button> -->
         <form action="/project/authentication/login.php" method="post">
  <button type="submit" name="logout" class="btn btn-danger">Logout</button>
</form>

        </div>
        </div>
            <div class="card-section">
    <div class="card" >
        <div class="ctitle">Total Income</div>
        <div class="cnumbers">₹<?php echo " ".$totalIncome; ?></div>
    </div>
    <div class="card">
        <div class="ctitle">Total Expense</div>
        <div class="cnumbers"> ₹<?php echo " ".$totalExpense; ?></div>
    </div>
    <div class="card">
        <div class="ctitle">Net Profit</div>
        <div class="cnumbers"> ₹<?php echo " ".$netProfit; ?></div>
    </div>
    <div class="card">
        <div class="ctitle">Monthly Growth</div>
        <div class="cnumbers"> ₹<?php echo " ".$monthlyGrowth; ?></div>
    </div>
</div>

      

      <!-- Buttons -->
      <div class="btn-section">
                <!-- <button type="submit"  onclick="window.location.href='./add_category.php'" name="insertCategory" class="btn btn-primary">Insert Category</button> -->
        <button type="submit"onclick="window.location.href='/project/insertTransaction.php'" name="insertTransaction" class="btns">Insert Transaction</button>
      </div>
      <!-- Tables Section -->
      <div class="tables">
        <!-- Categories Table -->
        <div class="table-wrapper">
          <h5>Categories</h5>
          <table class="table table-striped">
            <thead>
              <tr><th>ID</th><th>Name</th></tr>
            </thead>
            <tbody>
              <?php
              $query = mysqli_query($conn, "SELECT * FROM categories");
              if ($query && mysqli_num_rows($query) >= 1) {
                while ($row = mysqli_fetch_assoc($query)) {
                  echo "<tr><td>{$row['id']}</td><td>{$row['name']}</td></tr>";
                }
              }
              ?>
            </tbody>
          </table>
        </div>

        <!-- Users Table -->
        <div class="table-wrapper">
          <h5>Users</h5>

          <table class="table table-striped">
            <thead>
              <tr><th>ID</th><th>Username</th><th>Email</th><th>Role</th><th>Created</th></tr>
            </thead>
            <tbody>
              <?php
              $query = mysqli_query($conn, "SELECT * FROM users");
              if ($query && mysqli_num_rows($query) >= 1) {
                while ($row = mysqli_fetch_assoc($query)) {
                  echo "<tr>
                          <td>{$row['id']}</td>
                          <td>{$row['username']}</td>
                          <td>{$row['email']}</td>
                          <td>{$row['role']}</td>
                          <td>{$row['created_at']}</td>
                        </tr>";
                }
              }
              ?>
            </tbody>
          </table>
        </div>

        <!-- Transactions Table -->
        <div class="table-wrapper">
          <h5>Transactions</h5>
          <table class="table table-striped">
            <thead>
              <tr><th>ID</th><th>Date</th><th>Type</th><th>Amount</th><th>Category ID</th><th>Mode</th><th>Description</th><th>Created</th><th>User Name</th></tr>
            </thead>
            <tbody>
              <?php
              $query = mysqli_query($conn, "SELECT * FROM transactions");
              if ($query && mysqli_num_rows($query) >= 1) {
                while ($row = mysqli_fetch_assoc($query)) {
                  echo "<tr>
                          <td>{$row['id']}</td>
                          <td>{$row['date']}</td>
                          <td>{$row['type']}</td>
                          <td>{$row['amount']}</td>
                          <td>{$row['category_id']}</td>
                          <td>{$row['mode']}</td>
                          <td>{$row['description']}</td>
                          <td>{$row['created_at']}</td>
                          <td>{$row['uname']}</td>
                        </tr>";
                }
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>


</body>
</html>
<script src="../assets/js/script.js"></script>