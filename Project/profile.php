<?php
include "./db.php";

session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ./authentication/login.php");
    exit();
}

if(isset($_POST['back'])){
    if($_SESSION["role"] == "admin"){
        header("Location: ./admin/admin_dashboard.php");
        exit();
    } else {
        header("Location: ./user/user_dashboard.php");
        exit();
    }
}

// Popup notification logic
$popupMsg = '';
$popupType = '';
if (isset($_GET['success'])) {
    $popupMsg = 'Profile updated successfully!';
    $popupType = 'success';
} elseif (isset($_GET['nochange'])) {
    $popupMsg = 'No changes detected.';
    $popupType = 'info';
} elseif (isset($_GET['error'])) {
    $popupMsg = 'Error updating profile.';
    $popupType = 'error';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Profile</title>
  <style></style>
  <link rel="stylesheet" href="./assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="./assets/css/profile_style.css">
  <link rel="stylesheet" href="./assets/css/notification.css">

</head>
<body>
  
  
  
  <div class="profile-card">
    <div class="btn-section">

      <form method="post">
        <button class="back-btn" type="submit" name="back" >← Back</button>
      </form>
      <form action="/project/authentication/logout.php" method="post">
        <button type="submit" name="logout" class=" logout-top-btn btn  btn-danger">Logout</button>
      </form>
    </div>

    <!-- Back Button -->

    <div class="profile-header">
      <div class="profile-image">
        <img src="https://cdn-icons-png.flaticon.com/512/149/149071.png" alt="User">
      </div>
      
    </div>
    <div class="profile-body">
      <h2><?php echo $_SESSION['username'];?></h2>
      <p><?php if($_SESSION['role'] == "admin") {echo "Owner";}else {echo "Accountant";}?></p>

      <div class="profile-details">
                <?php
          $currentUser = $_SESSION['username'];

        // Fetch current user details
        $query = mysqli_query($conn, "SELECT * FROM users WHERE username = '$currentUser' LIMIT 1");

        if ($query && mysqli_num_rows($query) > 0) {
         $row = mysqli_fetch_assoc($query);
    ?>
    <!-- Stylish Popup Notification -->
    <?php if ($popupMsg): ?>
    <div id="popup-notification" class="popup-notification <?php echo $popupType; ?>">
      <?php echo $popupMsg; ?>
    </div>
    <?php endif; ?>
    <div class="edit-form">
        <form method="POST" action="./update_profile.php" id="updateProfileForm">
          <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

          <label>Username</label>
          <input type="text" name="username" id="username" value="<?php echo $row['username']; ?>" required minlength="3">
          <div class="error-msg" id="usernameError"></div>

          <label>Email</label>
          <input type="email" name="email" id="email" value="<?php echo $row['email']; ?>" required>
          <div class="error-msg" id="emailError"></div>

          <label>Role</label>
          <input type="text" name="role" value="<?php echo $row['role']; ?>" readonly>

          <label>Created At</label>
          <input type="text" value="<?php echo $row['created_at']; ?>" readonly>
          <div class="form-group">
            <button type="submit"  name="update">Update Profile</button>
            <button type="button" onclick="window.location.href='/project/changePWD.php'" name="changePwd">Change Password</button>
          </div>
          </form>
      </div>

    <?php
} ?>
        </ul>
      </div>

     

    </div>
  </div>

 
<script>
window.addEventListener('DOMContentLoaded', function() {
  const popup = document.getElementById('popup-notification');
  if (popup) {
    setTimeout(() => {
      popup.classList.add('hide');
    }, 2000);
  }
  // Client-side validation
  const form = document.getElementById('updateProfileForm');
  if (form) {
    form.addEventListener('submit', function(e) {
      let valid = true;
      const username = document.getElementById('username').value.trim();
      const email = document.getElementById('email').value.trim();
      const usernameError = document.getElementById('usernameError');
      const emailError = document.getElementById('emailError');
      usernameError.textContent = '';
      emailError.textContent = '';
      if (username.length < 3) {
        usernameError.textContent = 'Username must be at least 3 characters.';
        valid = false;
      }
      const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailPattern.test(email)) {
        emailError.textContent = 'Enter a valid email address.';
        valid = false;
      }
      if (!valid) e.preventDefault();
    });
  }
});
</script>
</body>
</html>
