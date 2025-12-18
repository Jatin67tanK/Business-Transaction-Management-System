
    const form = document.getElementById('passwordForm');
    const oldPassword = document.getElementById('old_password');
    const newPassword = document.getElementById('new_password');
    const confirmPassword = document.getElementById('confirm_password');

    const oldError = document.getElementById('old_error');
    const newError = document.getElementById('new_error');
    const confirmError = document.getElementById('confirm_error');

    form.addEventListener('submit', function(e) {
      let valid = true;

      // Reset error messages
      oldError.textContent = "";
      newError.textContent = "";
      confirmError.textContent = "";

      // Validate Old Password
      if (oldPassword.value.trim() === "") {
        oldError.textContent = "Old password is required.";
        valid = false;
      }

      // Validate New Password
      if (newPassword.value.trim().length < 6) {
        newError.textContent = "New password must be at least 6 characters.";
        valid = false;
      }

      // Validate Confirm Password
      if (confirmPassword.value.trim() === "") {
        confirmError.textContent = "Please confirm new password.";
        valid = false;
      } else if (confirmPassword.value !== newPassword.value) {
        confirmError.textContent = "Passwords do not match.";
        valid = false;
      }

      if (!valid) {
        e.preventDefault(); // Stop form submission if errors exist
      }
    });
 