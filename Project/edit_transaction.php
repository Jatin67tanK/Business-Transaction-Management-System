<?php

session_start();


include "./db.php";
if(!isset($_SESSION['username'])){
    header("Location: /project/authentication/login.php");
    exit();
}

if (isset($_POST['back']) ) {
    header("Location: /project/insertTransaction.php");
    exit();
    }


?>
<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    <link rel="stylesheet" href="./admin/css/sidebar.css"> 
    <link rel="stylesheet" href="./assets/css/insertTransaction.css">
    <style>
        .info{
  color: red;
  font-size: 14px;
  margin-top: -10px;
  margin-bottom: 10px;
}

.success{
        color: green;
        
}
    </style>
</head>
<body>
        <div class="dashboard">
                <div class="head-section">
                 <h3 class="logo">CashFlowX</h3>
            <!-- 🔝 Header -->
                <h3 >Edit Transaction</h3>
                <div class="btn btn-section">
                    <form  method="post"><button type="submit" class="btn btn-dark" name="back">Back</button></form>
                </div>
            </div>
            <!-- 📝 Add Transaction Form -->
           <div class="form-container">
<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the current transaction from DB
    $query = mysqli_query($conn, "SELECT * FROM transactions WHERE id = $id");
    if ($query && mysqli_num_rows($query) == 1) {
        $trow = mysqli_fetch_assoc($query);
    if($_SESSION["role"] != 'admin' && $_SESSION["username"] != $trow['uname']){
        echo "<p class='error'>Access denied. Only admin can edit transactions.</p>";
        exit();
    }


        // Handle form submission
        if (isset($_POST['save'])) {
            // Get form values
            $date = $_POST['date'];
            $type = $_POST['type'];
            $amount = $_POST['amount'];
            $category = $_POST['category'];
            $mode = $_POST['mode'];
            $description = $_POST['description'];

            // Check if any value is different from the old record
            if (
                $date != $trow['date'] ||
                $type != $trow['type'] ||
                $amount != $trow['amount'] ||
                $category != $trow['category_id'] ||
                $mode != $trow['mode'] ||
                $description != $trow['description']
            ) {
                // Update record
                $update = mysqli_query($conn, "UPDATE transactions SET 
                    date='$date',
                    type='$type',
                    amount='$amount',
                    category_id='$category',
                    mode='$mode',
                    description='$description'
                    WHERE id=$id
                ");

                if ($update) {
                    echo "<p class='success'>Record updated successfully!</p>";
                    // Refresh $trow to show updated values

                    $query = mysqli_query($conn, "SELECT * FROM transactions WHERE id = $id");
                    $trow = mysqli_fetch_assoc($query);
                     echo '<script>
                    setTimeout(() => {
                        window.location.href = "./insertTransaction.php";
                    }, 1500);
                  </script>';
                } else {
                    echo "<p class='error'>Update failed: ".mysqli_error($conn)."</p>";
                }
            } else {
                echo "<p class='info'>No changes detected.</p>";
            }
        }
?>

<form method="POST" class="transaction-form">
    <!-- Date -->
    <div class="form-group">
        <label for="date">Date</label>
        <input type="date" value="<?php echo htmlspecialchars($trow['date']); ?>" id="date" name="date" required>
    </div>

    <!-- Type -->
    <div class="form-group">
        <label for="type">Type</label>
        <select id="type" name="type" required>
            <option value="income" <?php if($trow['type']=='income') echo 'selected'; ?>>Income</option>
            <option value="expense" <?php if($trow['type']=='expense') echo 'selected'; ?>>Expense</option>
        </select>
    </div>

    <!-- Amount -->
    <div class="form-group">
        <label for="amount">Amount</label>
        <input type="number" value="<?php echo htmlspecialchars($trow['amount']); ?>"  step="0.01" id="amount" name="amount" placeholder="0.00" required>
    </div>

    <!-- Category -->
    <div class="form-group">
        <label for="category">Category</label>
        <select id="category" name="category" required>
            <?php
            $check = mysqli_query($conn, "SELECT * FROM categories");
            if ($check && mysqli_num_rows($check) >= 1) {
                while ($row = mysqli_fetch_assoc($check)) {
            ?>
                    <option value="<?php echo $row['id']; ?>" <?php if($row['id']==$trow['category_id']) echo 'selected'; ?>>
                        <?php echo htmlspecialchars($row['name']); ?>
                    </option>
            <?php
                }
            } else {
                echo "<option disabled>No category available</option>";
            }
            ?>
        </select>
    </div>

    <!-- Mode -->
    <div class="form-group">
        <label for="mode">Mode</label>
        <select id="mode" name="mode" required>
            <option value="cash" <?php if($trow['mode']=='cash') echo 'selected'; ?>>Cash</option>
            <option value="bank" <?php if($trow['mode']=='bank') echo 'selected'; ?>>Bank</option>
            <option value="upi" <?php if($trow['mode']=='upi') echo 'selected'; ?>>UPI</option>
        </select>
    </div>

    <!-- Notes -->
    <div class="form-group notes">
        <label for="description">Notes</label>
        <textarea id="description" name="description" placeholder="Optional"><?php echo htmlspecialchars($trow['description']); ?></textarea>
    </div>

    <!-- Buttons -->
    <div class="form-actions">
        <button type="submit" name="save" class="btn save">✔ Save</button>
        <button type="button" name="reset" class="btn reset" onclick="resetForm()">↺ Reset</button>
    </div>
</form>

<script>
    // Reset button restores original DB values
    function resetForm() {
        document.getElementById('date').value = "<?php echo $trow['date']; ?>";
        document.getElementById('type').value = "<?php echo $trow['type']; ?>";
        document.getElementById('amount').value = "<?php echo $trow['amount']; ?>";
        document.getElementById('category').value = "<?php echo $trow['category_id']; ?>";
        document.getElementById('mode').value = "<?php echo $trow['mode']; ?>";
        document.getElementById('description').value = "<?php echo addslashes($trow['description']); ?>";
    }
</script>

<?php
    }
}
?>
</div>

            <!-- 📊 Transactions Table -->
        </div>

<script src="./assets/js/script.js"></script>

</body>
</html>