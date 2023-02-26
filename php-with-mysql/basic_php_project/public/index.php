<?php require_once('../private/initialize.php'); ?>

<?php
if (isset($_GET['preview']) && $_GET['preview'] === 'true')
  $preview = true;
else
  $preview = false;
?>

<?php include(SHARED_PATH . '/public_header.php'); ?>

<div id="main">

  <?php
  if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $page = db_find_page($id);
    if (!$page)
      redirect_to('index.php');
    if (!$page['visible']) {
      if (!is_logged_in() or !$preview)
        redirect_to('index.php');
    }
    $subject_id = $page['subject_id'];
  } else {
    $id = null;
    $page = null;
    $subject_id = null;
  }
  ?>

  <?php include(SHARED_PATH . '/public_navigation.php') ?>

  <div id="page">

    <?php

    if ($page) {
      echo $page['content'];
    } else {
      include(SHARED_PATH . '/static_homepage.php');
    }

    ?>


  </div>

</div>

<?php include(SHARED_PATH . '/public_footer.php'); ?>