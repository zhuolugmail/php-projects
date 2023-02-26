<?php

require_once('../../../private/initialize.php');

require_login();

if (!isset($_GET['id'])) {
  redirect_to(url_for('/staff/admins/index.php'));
}
$id = $_GET['id'];

if (is_post_request()) {
  $result = db_delete_admin($id);
  if ($result) {
    $_SESSION['status'] = 'Admin deleted';
    redirect_to('/staff/admins/index.php');
  }
} else {
  $admin = db_find_admin($id);
}

?>

<?php $page_title = 'Delete Admin'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">

  <a class="back-link" href="<?php echo url_for('/staff/admins/index.php'); ?>">&laquo; Back to List</a>

  <div class="subject delete">
    <h1>Delete Admin</h1>
    <p>Are you sure you want to delete this admin?</p>


    <p>
      <span style="strong">Id: </span>
      <?php echo $admin['id']; ?>
    </p>
    <p>
      <span style="strong">Name: </span>
      <?php echo $admin['first_name'] . ' ' . $admin['last_name']; ?>
    </p>
    <p>
      <span style="strong">Email: </span>
      <?php echo $admin['email']; ?>
    </p>
    <p>
      <span style="strong">Username: </span>
      <?php echo $admin['username']; ?>
    </p>

    <form action="<?php echo url_for('/staff/admins/delete.php?id=' . h(u($id))); ?>" method="post">
      <div id="operations">
        <input type="submit" name="commit" value="Delete Subject" />
      </div>
    </form>
  </div>

</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>