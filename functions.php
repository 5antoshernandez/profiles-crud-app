<?php
function checklogin() {
  if ( ! isset($_SESSION['user_id']) ) {
    die('Please login.');
  }
}

?>
