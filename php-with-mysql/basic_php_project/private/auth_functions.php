<?php

// Performs all actions necessary to log in an admin
function log_in_admin($admin)
{
  // Renerating the ID protects the admin from session fixation.
  session_regenerate_id();
  $_SESSION['admin_id'] = $admin['id'];
  $_SESSION['last_login'] = time();
  $_SESSION['username'] = $admin['username'];
  return true;
}

function log_out_admin()
{
  unset($_SESSION['admin_id']);
  unset($_SESSION['username']);
  return true;
}

function is_logged_in()
{
  return isset($_SESSION['admin_id']);
}

function require_login()
{
  if (!is_logged_in()) {
    redirect_to('staff/login.php');
  }
}
?>