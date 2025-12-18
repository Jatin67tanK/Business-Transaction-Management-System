<?php
session_start();
include "./db.php";

// Notification logic
$notifyMsg = '';
$notifyType = '';
if (isset($_GET['msg'])) {
    $msg = $_GET['msg'];
    if ($msg === 'success') {
        $notifyMsg = '✅ Password updated successfully!';
        $notifyType = 'success';
    } elseif ($msg === 'oldwrong') {
        $notifyMsg = '❌ Old password is incorrect.';
        $notifyType = 'error';
    } elseif ($msg === 'mismatch') {
        $notifyMsg = '❌ New password and confirm password do not match.';
        $notifyType = 'error';
    } elseif ($msg === 'samepwd') {
        $notifyMsg = '❌ New password must be different from old password.';
        $notifyType = 'error';
    } elseif ($msg === 'error') {
        $notifyMsg = '❌ Error updating password.';
        $notifyType = 'error';
    } elseif ($msg === 'notfound') {
        $notifyMsg = '❌ User not found.';
        $notifyType = 'error';
    }
}

// // Check if user logged in
// if (!isset($_SESSION["username"])) {
//     header("Location: login.php");
//     exit();
// }

$username =  $_SESSION["username"] ;

if (isset($_POST['updatePwd'])) {
    $old_pwd = md5($_POST['old_password']);
    $new_pwd = md5($_POST['new_password']);
    $confirm_pwd = md5($_POST['confirm_password']);

    // Check if new password and confirm match
    if ($new_pwd !== $confirm_pwd) {
        header("Location: changePWD.php?msg=mismatch");
        exit();
    }
    // Check if new password is same as old password
    if ($old_pwd === $new_pwd) {
        header("Location: changePWD.php?msg=samepwd");
        exit();
    }

    // Fetch current password from DB
    $queryCheck = "SELECT password FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $queryCheck);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $db_password = $row['password'];

        // Verify old password
        if ($db_password === $old_pwd) {
            // Update DB with new md5 password
            $update = "UPDATE users SET password = '$new_pwd' WHERE username = '$username'";
            if (mysqli_query($conn, $update)) {
                header("Location: changePWD.php?msg=success");
                exit();
            } else {
                header("Location: changePWD.php?msg=error");
                exit();
            }
        } else {
            header("Location: changePWD.php?msg=oldwrong");
            exit();
        }
    } else {
        header("Location: changePWD.php?msg=notfound");
        exit();
    }
}
?>
  
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Change Password</title>
        <link rel="stylesheet" href="./assets/css/changePWD.css">
        <link rel="stylesheet" href="./assets/css/notification.css">
</head>
<body>
  <?php if ($notifyMsg): ?>
  <div class="notification-popup <?php echo $notifyType; ?>" id="notifyBox">
    <?php echo $notifyMsg; ?>
  </div>
  <?php endif; ?>
  <a href="/project/profile.php" class="btn back">⬅ Back</a>
  <div class="container">

      <h2>🔒 Change Password</h2>

     

      <form method="POST" id="passwordForm" novalidate>

          <div class="form-group">
              <label>Old Password</label>
              <input type="password" name="old_password" id="old_password" required>
              <div class="input-error" id="old_error"></div>
          </div>
          <div class="form-group">
              <label>New Password</label>
              <input type="password" name="new_password" id="new_password" required>
              <div class="input-error" id="new_error"></div>
          </div>
          <div class="form-group">
              <label>Confirm New Password</label>
              <input type="password" name="confirm_password" id="confirm_password" required>
              <div class="input-error" id="confirm_error"></div>
          </div>

          <div class="btn-section">
              <button type="submit" name="updatePwd" class="btn">Update Password</button>
          </div>
      </form>
  </div>

  <style>
.notification-popup {
  position: fixed;
  top: 30px;
  left: 50%;
  transform: translateX(-50%);
  z-index: 9999;
  padding: 18px 36px;
  border-radius: 10px;
  color: #fff;
  font-size: 1.15rem;
  font-weight: 600;
  opacity: 1;
  box-shadow: 0 6px 24px rgba(0,0,0,0.18);
  background: #2563eb;
  transition: opacity 0.5s, top 0.5s;
  letter-spacing: 0.5px;
  text-align: center;
}
.notification-popup.success { background: #22c55e; }
.notification-popup.error { background: #e11d48; }
.notification-popup.hide { opacity: 0; top: 0; pointer-events: none; }
</style>
  <script>
// Hide notification after 2 seconds
window.addEventListener('DOMContentLoaded', function() {
  const notify = document.getElementById('notifyBox');
  if (notify) {
    setTimeout(() => {
      notify.classList.add('hide');
    }, 2000);
  }

  // Client-side validation
  document.getElementById('passwordForm').addEventListener('submit', function(e) {
    let valid = true;
    const oldPwd = document.getElementById('old_password').value.trim();
    const newPwd = document.getElementById('new_password').value.trim();
    const confirmPwd = document.getElementById('confirm_password').value.trim();
    document.getElementById('old_error').textContent = '';
    document.getElementById('new_error').textContent = '';
    document.getElementById('confirm_error').textContent = '';
    if (oldPwd.length < 6) {
      document.getElementById('old_error').textContent = 'Old password must be at least 6 characters.';
      showClientNotification('Old password must be at least 6 characters.', 'error');
      valid = false;
    }
    if (newPwd.length < 6) {
      document.getElementById('new_error').textContent = 'New password must be at least 6 characters.';
      showClientNotification('New password must be at least 6 characters.', 'error');
      valid = false;
    }
    if (newPwd !== confirmPwd) {
      document.getElementById('confirm_error').textContent = 'Passwords do not match.';
      showClientNotification('Passwords do not match.', 'error');
      valid = false;
    }
    if (oldPwd && newPwd && oldPwd === newPwd) {
      document.getElementById('new_error').textContent = 'New password must be different from old password.';
      showClientNotification('New password must be different from old password.', 'error');
      valid = false;
    }
    if (!valid) e.preventDefault();
  });

  // Show notification for client-side validation
  function showClientNotification(msg, type) {
    let existing = document.getElementById('notifyBox');
    if (existing) existing.remove();
    const div = document.createElement('div');
    div.id = 'notifyBox';
    div.className = 'notification-popup ' + type;
    div.textContent = msg;
    document.body.appendChild(div);
    setTimeout(() => {
      div.classList.add('hide');
    }, 2000);
  }
});
</script>
</body>
</html>
