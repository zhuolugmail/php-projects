<?php require_once('../../private/initialize.php'); ?>

<?php /* unset($_SESSION['admin_id']); */?>
<?php require_login() ?>

<?php include(SHARED_PATH . '/head.php'); ?>

<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">
  <div id="main-menu">
    <h2>Main Menu</h2>
    <ul>
      <li>
        <a href="/public/staff/admins/index.php">Admins</a>
      </li>
      <li>
        <a href="/public/staff/subjects/index.php">Subjects</a>
      </li>
    </ul>
  </div>
</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>