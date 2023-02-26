<?php
require_once('../../private/initialize.php');

$errors = [];
$username = '';
$password = '';

if (is_post_request()) {
  $error_message = 'Login failed.';
  $username = $_POST['username'] ?? '';
  $password = $_POST['password'] ?? '';
  if (is_blank($username))
    $errors[] = 'Username cannot be blank.';
  if (is_blank($password))
    $errors[] = 'Password cannot be blank.';
  if (count($errors) <= 0) {
    $admin = db_find_admin_by_username($username);
    if ($admin) {
      if (password_verify($password, $admin['hashed_password'])) {
        log_in_admin($admin);
        $_SESSION['status'] = 'You have logged in.';
        redirect_to('/staff/index.php');
      } else {
        $errors[] = $error_message;
      }
    } else {
      $errors[] = $error_message;
    }
  }

}

?>

<?php $page_title = 'Log in'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">
  <h1>Log in</h1>

  <?php echo display_errors($errors); ?>

  <form action="login.php" method="post">
    Username:<br />
    <input type="text" name="username" value="<?php echo h($username); ?>" /><br />
    Password:<br />
    <input type="password" name="password" value="" /><br />
    <input type="submit" name="submit" value="Submit" />
  </form>

</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>