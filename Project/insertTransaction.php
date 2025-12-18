<?php

session_start();


include "./db.php";
if (isset($_POST['back']) && $_SESSION["role"] == 'admin') {
    header("Location: ./admin/admin_dashboard.php");
    exit();
    }
elseif (isset($_POST['back']) && $_SESSION["role"] == 'user'){
     header("Location: ./user/user_dashboard.php");
        exit();
    }

?>
<!DOCTYPE html>
<html lang="en">
<style>
    .btn-col .btn{
        background-color: none;
          color:rgb(255, 255, 255) !important;
        background-color: #2563eb;
    }
    button a{
        text-decoration: none !important;
        /* border-radius: 5px; */
        align-items: center;
    }
    .form-actions {
    /* grid-column: span 2; */
    /* display: flex
; */
    justify-content: flex-end !important;
    gap: 12px !important;
    /* /* margin-top: 15px; */
}
    .save {
        width: 100px;
    }
    .edit-section {
  padding: 15px 35px;
  position: absolute;
  width: auto    !important;
  height: auto ;
  top: 0;
  right: 15%;
  border-radius: 10px;
  background:rgb(221, 231, 231);
  color: #2563eb;
  font-weight: 600;
  text-align: center;
}
.table thead th{
  text-align: center;
}
.edit-section .transaction-form {
  display: block;

}
.edit-section .transaction-form  input, .edit-section .transaction-form select, .edit-section .transaction-form textarea {
  width: 100%;
  padding: 10px;
  margin: 8px 0;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;


}
 th,  td {
padding: 5px !important;
}

 tr, td{
  height: 50px !important;

}
td input{
  background-color: rgba(255, 255, 255, 0) ;
  border: 0px rgba(255, 255, 255, 0) !important;
  border: 0 !important;
  padding: 0;
      text-align: center;
}

.btn-col {
    width: auto;
  display: flex;
  height: 100%;
  flex-direction: row   ;
  gap: 5px;
}
</style>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Transaction</title>
    <link rel="stylesheet" href="./assets/css/insertTransaction.css">
    <link rel="stylesheet" href="./assets/css/bbootstrap.min.css">
    <link rel="stylesheet" href="./admin/css/sidebar.css"> 
    <link rel="stylesheet" href="./assets/css/Searchbar.css">
     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


  <script>
$(document).ready(function() {
    $("#searchBtn").click(function() {  // Trigger on Submit button click
        var searchTerm = $("#searchbar").val().trim(); // Get input value

        $.ajax({
            url: '/project/admin/fetch_record.php',  // PHP file that handles search
            type: 'POST',
            data: {
                search: searchTerm,
                table: 'transactions',
                uname: '<?php echo $_SESSION["username"]; ?>',
                role: '<?php echo $_SESSION["role"]; ?>'
            },
            success: function(response) {
                $("table tbody").html(response);  // Replace table body with search results
            },
            error: function() {
                alert("Error fetching search results.");
            }
        });
    });
});
</script>

  
    <!-- Corrected path for sidebar.css -->
</head>

<body>

    <div class="main-containers">
     <?php    
     if($_SESSION["role"] == 'admin') {
    include "./sidebar.php";
    ?><link rel="stylesheet" href="./css/sidebar.css">
<?php
    }
    else{
    include "./sidebar.php";
?>
<link rel="stylesheet" href="./css/sidebar.css">
<?php
    } ?>

 
        <div class="dashboard">
            <!-- 🔝 Header -->
            <div class="head-section">
                <div id="hamburger" class="hamburger">☰</div>
                <h3 class="logo">CashFlowX</h3>
                <div class="btn btn-section">
                    <form  method="post"><button type="submit" class="btn btn-dark" name="back">Back</button></form>
                </div>
            </div>
            <!-- 📝 Add Transaction Form -->
            <div class="form-container">
                <h2>Add New Transaction</h2>
                <form method="POST" class="transaction-form">

                    <!-- Date -->
                    <div class="form-group">
                        <label for="date">Date</label>
                        <input type="date" id="date" name="date" required>
                    </div>

                    <!-- Type -->
                    <div class="form-group">
                        <label for="type">Type</label>
                        <select id="type" name="type" required>
                            <option value="income">Income</option>
                            <option value="expense">Expense</option>
                        </select>
                    </div>

                    <!-- Amount -->
                    <div class="form-group">
                        <label for="amount">Amount</label>
                        <input type="number" step="0.1" id="amount" name="amount" placeholder="0.00" required>
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
                                    <!-- We store only category ID -->
                                    <option value="<?php echo $row['id']; ?>">
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
                            <option value="cash">Cash</option>
                            <option value="bank">Bank</option>
                            <option value="upi">UPI</option>
                        </select>
                    </div>

                    <!-- Notes -->
                    <div class="form-group notes">
                        <label for="description">Notes</label>
                        <textarea id="description" name="description" placeholder="Optional"></textarea>
                    </div>

                    <!-- Buttons -->
                    <!-- <div class="form-actions"> -->
                        <button type="submit" name="save" class="btn save">Save</button>
                    <!-- </div> -->
                </form>
            </div>

            <!-- 📊 Transactions Table -->
           <div class="table-container">
            <div class="search-section">
    <input type="text" id="searchbar" class="Search-bar" placeholder="Search Transactions..." />
    <button type="button" id="searchBtn">Submit</button>
</div>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Date</th>
                <th>Type</th>
                <th>Amount</th>
                <th>Category ID</th>
                <th>Mode</th>
                <th>Description</th>
                <th>Created Time</th>
                <th>User Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // if($_SESSION["role"] == 'admin'){
            $query = mysqli_query($conn, "SELECT * FROM transactions");
            // }
            // else{
            //     $uname =   $_SESSION["username"];
            // $query = mysqli_query($conn, "SELECT * FROM transactions where uname = '$uname' ");
            // }
            // if ($query && mysqli_num_rows($query) >= 1) {
                while ($row = mysqli_fetch_assoc($query)) {
            ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><?php echo htmlspecialchars($row['date']); ?></td>
                    <td><?php echo htmlspecialchars($row['type']); ?></td>
                    <td><?php echo htmlspecialchars($row['amount']); ?></td>
                    <td><?php echo htmlspecialchars($row['category_id']); ?></td>
                    <td><?php echo htmlspecialchars($row['mode']); ?></td>
                    <td><?php echo htmlspecialchars($row['description']); ?></td>
                    <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                    <td><?php echo htmlspecialchars($row['uname']); ?></td>
          <?php  if($_SESSION["role"] == 'admin' || $row['uname'] == $_SESSION["username"]) { ?>
                    
                    <td class="btn-col" >
                        <form method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this record?');">

                        <!-- Update button links to edit page with record id -->
                        <button class="btn  " type="button" onclick=" window.location.href='/project/edit_Transaction.php?id=<?php echo $row['id']; ?>'">Update</button>

                        <!-- Delete button -->
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <button type="submit" style="background-color: red  ; color: white;" name="delete" class="btn ">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php
                }
            }
            ?>
        </tbody>
    </table>
</div>

        </div>
    </div>

    <script src="./assets/js/script.js"></script> <!-- Corrected path for script.js -->

    <?php
    if (isset($_POST['save'])) {
        $date = $_POST['date'];
        $type = $_POST['type'];
        $amount = $_POST['amount'];
        $category = $_POST['category'];
        $mode = $_POST['mode'];
        $description = $_POST['description'];
        $uname = $_SESSION["username"];

        $query = "INSERT INTO transactions (date,type,amount,category_id,mode,description,uname) 
                  VALUES ('$date','$type','$amount','$category','$mode','$description','$uname')";
        $result = mysqli_query($conn, $query);

        if ($result) {
            echo "<script>alert('Transaction added successfully!');</script>";
            echo "<script> window.location.href = './insertTransaction.php';</script>";
        } else {
            echo "<script>alert('Transaction not added!');</script>";
        }
    }

    // Handle Update


// Handle Delete
if (isset($_POST['delete'])) {
    $id = $_POST['id'];

    $deleteQuery = "DELETE FROM transactions WHERE id='$id'";
    if (mysqli_query($conn, $deleteQuery)) {
        echo "<script>alert('Record deleted successfully!'); window.location.href=window.location.href;</script>";
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
}
    
    ?>
</body>
<script src="./assets/js/script.js"></script>
</html>



