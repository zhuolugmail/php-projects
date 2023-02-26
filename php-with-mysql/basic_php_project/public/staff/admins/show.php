<?php
require_once('../../../private/initialize.php');

require_login();

$id = uh($_GET['id'] ?? 1);
$admin = db_find_admin($id);

$page_title = 'Admin: ' . $admin['first_name'] . ' ' . $admin['last_name'];
?>
<?php include(SHARED_PATH . '/head.php'); ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

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

<?php include(SHARED_PATH . '/staff_footer.php'); ?>