<Script>                
window.onpageshow = function(event) {
    if (event.persisted) {
      window.location.reload();
    }
  };</script><?php

if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("Location: ../index.php");
    exit();
}
?>
