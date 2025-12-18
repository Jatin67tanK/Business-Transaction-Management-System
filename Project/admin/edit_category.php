<?php include '../db.php'; 
  session_start();
  if (!isset($_SESSION['username']) || $_SESSION["role"] != 'admin') {
        // Not logged in → send them to login page
        header("Location: ../authentication/login.php");
        exit();
}

if (isset($_POST['back'])) {
    header("Location: ./add_category.php");
    exit();
}
  
  ?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Add Category</title>
      <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
      <link rel="stylesheet" href="./css/addCat_style.css">
      
      <link rel="stylesheet" href="./css/admin.css">
  </head>
<style>
   
/* Container */
.category-form {
    display: grid;
    background: #fff;
    border-radius: 12px;
    padding: 20px;
    margin: 15px auto;
    max-width: 500px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    transition: transform 0.2s ease-in-out;
}
.category-form:hover {
    transform: translateY(-3px);
}

/* Heading */
.category-form h4 {
    margin-bottom: 15px;
    font-size: 1.2rem;
    color: #333;
    border-bottom: 2px solid #eee;
    padding-bottom: 5px;
}

/* Form Group */
.category-form .form-group {
    margin-bottom: 15px;
}
.category-form label {
    display: block;
    font-size: 0.95rem;
    font-weight: 600;
    margin-bottom: 6px;
    color: #444;
}
.category-form input[type="text"],
.category-form textarea,
.category-form select {
    width: 100%;
    padding: 10px 12px;
    border: 1px solid #ccc;
    border-radius: 8px;
    font-size: 0.95rem;
    transition: border-color 0.3s ease;
}
.category-form input:focus,
.category-form textarea:focus,
.category-form select:focus {
    outline: none;
    border-color: #007bff;
    box-shadow: 0 0 5px rgba(0,123,255,0.2);
}

/* Buttons */
.category-form .form-actions {
    display: block;
    justify-content: flex-end;
    gap: 10px;
}
.category-form .btn {
    padding: 10px 18px;
    font-size: 0.95rem;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
    border: none;
}
.category-form .btn.save {
    background: #007bff;
    color: #fff;
}
.category-form .btn.save:hover {
    background: #0056b3;
}
.category-form .btn.reset {
    background: #f8f9fa;
    border: 1px solid #ddd;
    color: #333;
}
.category-form .btn.reset:hover {
    background: #e2e6ea;
}

/* Responsive */
@media (max-width: 600px) {
    .category-form {
        padding: 15px;
        margin: 10px;
    }
    .category-form h4 {
        font-size: 1rem;
    }
    .category-form .form-actions {
        flex-direction: column;
    }
    .category-form .btn {
        width: 100%;
    }
}


        .form-container {
                padding: 0 25px;
        }
        .success {
            color: green;
        }

        .info {
            color: blue;
        }

        .error {
            color: red;
        }

</style>
  <body>
      <div class="main-container">
          <?php include "../sidebar.php"; ?>
        
          <div class="dashboard">
              <div class="head-section">
                <div id="hamburger" class="hamburger">☰</div>
                <h3 class="logo">CashFlowX</h3>
                <div class="btn btn-section">
                    <form  method="post"><button type="submit" class="btn btn-dark" name="back">Back</button></form>
                    
                </div>
            </div>
              <div class="form-container">
<?php
// Fetch all categories
if(isset($_GET['id'])){
    $id = $_GET['id'];

$catQuery = mysqli_query($conn, "SELECT * FROM categories WHERE id = $id ");

if ($catQuery && mysqli_num_rows($catQuery) ==1) {
    while ($cat = mysqli_fetch_assoc($catQuery)) {
        $catId = $cat['id'];

        // Handle form submission for this category
        if (isset($_POST['save_cat'])) {
            $newName = $_POST['name'];

            // Check if values changed
            if ($newName != $cat['name']) {
                $update = mysqli_query($conn, "UPDATE categories SET 
                    name='$newName'
                    WHERE id=$catId
                ");

                if ($update) {

                    echo "<p class='success'>Category ID $catId updated successfully!</p>";
                    
                    // Refresh category data
                    $catQuery2 = mysqli_query($conn, "SELECT * FROM categories WHERE id=$catId");
                    $cat = mysqli_fetch_assoc($catQuery2);
                } else {
                    echo "<p class='error'>Update failed: ".mysqli_error($conn)."</p>";
                }
            } else {
                echo "<p class='info'>No changes detected for Category ID $catId.</p>";
                
            }
        }
?>

<form method="POST" class="category-form" style="border:1px solid #ccc; padding:10px; margin-bottom:15px;">
    <h4>Category ID: <?php echo $cat['id']; ?></h4>
    <div class="form-group">
        <label for="name_<?php echo $catId; ?>">Name</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($cat['name']); ?>" required>
    </div>
    <div class="form-actions">
        <button type="submit" name="save_cat" class="btn save">✔ Save</button>
        <button type="button" class="btn reset" onclick="resetCategoryForm(<?php echo $catId; ?>)">↺ Reset</button>
    </div>
</form>

<script>
function resetCategoryForm(id) {
    document.getElementById('name').value = "<?php echo addslashes($cat['name']); ?>";
}
</script>

<?php
    } // end while
}
} else {
    echo "<p>No categories found.</p>";
}

?>
</div>

          </div>        

      </div>

      </div>
      </div>
      <script src="./js/script.js"></script>

  </body>
  <script>
  </script>

  </html>