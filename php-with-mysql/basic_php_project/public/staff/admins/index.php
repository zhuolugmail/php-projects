<?php require_once('../../../private/initialize.php'); ?>

<?php
require_login();
$page_title = 'Admins';
?>

<?php

$admin_set = db_find_all_admins();

?>

<?php include(SHARED_PATH . '/head.php'); ?>

<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">
  <div class="subjects listing">
    <h1>Admins</h1>

    <div class="actions">
      <a class="action" href="<?php echo url_for('/staff/admins/new.php') ?>">Create New Admin</a>
    </div>

    <table class="list">
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Username</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
      </tr>

      <?php while ($admin = $admin_set->fetch()) { ?>
        <tr>
          <td>
            <?php echo $admin['id']; ?>
          </td>
          <td>
            <?php echo $admin['first_name'] . ' ' . $admin['last_name']; ?>
          </td>
          <td>
            <?php echo $admin['email']; ?>
          </td>
          <td>
            <?php echo $admin['username']; ?>
          </td>
          <td><a class="action" href="<?php
          echo url_for('/staff/admins/show.php' . '?id=' . $admin['id']);
          ?>">View
            </a></td>
          <td><a class="action" href="<?php
          echo url_for('/staff/admins/edit.php' . '?id=' . $admin['id']);
          ?>">Edit
            </a></td>
          <td><a class="action" href=" <?php
          echo url_for('/staff/admins/delete.php' . '?id=' . $admin['id']);
          ?>">Delete></a></td>
        </tr>
      <?php } ?>
    </table>

  </div>

</div>

<?php $admin_set = null; ?>
<?php include(SHARED_PATH . '/staff_footer.php'); ?>