<?php

require_once('../../../private/initialize.php');

if (!isset($_GET['id'])) {
  redirect_to(url_for('/staff/subjects/index.php'));
}
$id = $_GET['id'];

if (is_post_request()) {
  $result = db_delete_subject($id);
  if ($result) {

    db_subjectordering_delete($id);

    $db = null;
    $_SESSION['status'] = 'Subject deleted';
    redirect_to('/staff/subjects/index.php');
  }
} else {
  $subject = db_find_subject($id);
}

?>

<?php require_login() ?>

<?php $page_title = 'Delete Subject'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">

  <a class="back-link" href="<?php echo url_for('/staff/subjects/index.php'); ?>">&laquo; Back to List</a>

  <div class="subject delete">
    <h1>Delete Subject</h1>
    <p>Are you sure you want to delete this subject?</p>
    <p class="item">
      <?php echo h($subject['menu_name']); ?>
    </p>

    <form action="<?php echo url_for('/staff/subjects/delete.php?id=' . h(u($subject['id']))); ?>" method="post">
      <div id="operations">
        <input type="submit" name="commit" value="Delete Subject" />
      </div>
    </form>
  </div>

</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>