<?php
// Database connection (include this file where needed)
include "../db.php"; 

// Function: Total Income
function getTotalIncome($conn) {
    $sql = "SELECT SUM(amount) AS total_income FROM transactions WHERE type='income'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['total_income'] ?? 0; // if null, return 0
}

// Function: Total Expense
function getTotalExpense($conn) {
    $sql = "SELECT SUM(amount) AS total_expense FROM transactions WHERE type='expense'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['total_expense'] ?? 0;
}

// Function: Net Profit (Income - Expense)
function getNetProfit($conn) {
    $income = getTotalIncome($conn);
    $expense = getTotalExpense($conn);
    return $income - $expense;
}

// Function: Monthly Growth (current month income - last month income)
function getMonthlyGrowth($conn) {
    // Current month income
    $sql1 = "SELECT SUM(amount) AS curr_income 
             FROM transactions 
             WHERE type='income' 
             AND MONTH(date) = MONTH(CURDATE()) 
             AND YEAR(date) = YEAR(CURDATE())";
    $res1 = mysqli_query($conn, $sql1);
    $row1 = mysqli_fetch_assoc($res1);
    $curr_income = $row1['curr_income'] ?? 0;

    // Last month income
    $sql2 = "SELECT SUM(amount) AS last_income 
             FROM transactions 
             WHERE type='income' 
             AND MONTH(date) = MONTH(DATE_SUB(CURDATE(), INTERVAL 1 MONTH)) 
             AND YEAR(date) = YEAR(DATE_SUB(CURDATE(), INTERVAL 1 MONTH))";
    $res2 = mysqli_query($conn, $sql2);
    $row2 = mysqli_fetch_assoc($res2);
    $last_income = $row2['last_income'] ?? 0;

    // Avoid division by zero for percentage growth
    if ($last_income == 0) {
        return $curr_income; // or return 0 if you want no growth shown
    }

    // Monthly growth as difference
    return $curr_income - $last_income;
}

?>
