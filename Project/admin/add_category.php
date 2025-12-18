  <?php include '../db.php'; 
  session_start();
//   if (!isset($_SESSION['username']) || $_SESSION["role"] != 'admin') {
//         // Not logged in → send them to login page
//         header("Location: ../authentication/login.php");
//         exit();
// }

if (isset($_POST['back'])) {
    header("Location: ./admin_dashboard.php");
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
     <link rel="stylesheet" href="/project/assets/css/Searchbar.css">
      <!-- <link rel="stylesheet" href="./css/admin.css"> -->
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
                table: 'categories'
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
                <div class="btn btn-section">
                    <form  method="post"><button type="submit" class="btn btn-dark" name="back">Back</button></form>
                    
                </div>
            </div>
              <div class="form-container">
                 <div class="search-section">
                          <input type="text" id="search" class="Search-bar" placeholder="Search Category..." />
                        </div>
                  <div class="category-container">
                      <!-- Add new category -->
                     
                      
                      <div class="add-category">

                          <h2>Add New Category</h2>
                          <form method="POST" >
                              <input type="text" id="newCategory" name="name" placeholder="New category name" required>
                              <button type="submit" name="insert" class="btn add">➕ Add</button>
                            </form>
                        </div>

                      <div class="category-record">               
                          <hr>                          
                          <?php
                        $check = mysqli_query($conn, "SELECT * FROM categories");
                        if ($check && mysqli_num_rows($check) >= 1) {
                            while ($row = mysqli_fetch_assoc($check)) {
                                ?>
                              <form method="POST" class="category-item" onsubmit="return confirm('Are you sure you want to delete this record?');">
                                  <input type="text" name="id" value="<?php echo $row['id']; ?>" readonly>
                                  <input type="text" name="name" value="<?php echo htmlspecialchars($row['name']); ?>" readonly>
                                  <div class="btn-section">
                                      <a href="/project/admin/edit_category.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">Edit</a>
                                      <button type="submit" name='delete' class="btn delete">Delete</button>
                                    </div>
                                </form>
                                <?php
                            }
                        } else {
                            echo "<p>No categories found.</p>";
                        }
                        ?>
                    </div>
                      <!-- Categories List -->
                      <!-- Example items (these would normally come from PHP + MySQL loop) -->

                  </div>
              </div>
          </div>

      </div>

      </div>
      </div>
      <script src="./js/script.js"></script>

      <?php



        if (isset($_POST['insert'])) {

            $name = $_POST['name'];
            //to check category is alredy exist or not
            $check = mysqli_query($conn, "SELECT * FROM categories WHERE name='$name'");

            if ($check && mysqli_num_rows($check) == 0) {
                $query = "INSERT INTO categories (name) VALUES ('$name')";
                $result = mysqli_query($conn, $query);
                if ($result) {
                    echo "<script> window.location.href = './add_category.php';</script>";
                } else {
                    echo "<script>alert('Category Not added!');</script>";
                }
            } else {
                echo "<script>alert('Category already registered.'); </script> ";
            }
        }

        if (isset($_POST['delete'])) {
            $id = $_POST['id'];

            $query = "DELETE FROM  categories where id=$id";
    
            echo "<script>alert('Are you sure want to delete'); window.location.href = './add_category.php';</script>";
            $result = mysqli_query($conn, $query);
        }


        ?>
  </body>
  <script>
  </script>

  </html>