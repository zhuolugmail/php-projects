<?php require_once('../../../private/initialize.php'); ?>
<?php
require_login();
$error = [];

// Handle form values sent by new.php
if (is_post_request()) {
    $first_name = $_POST['first_name'] ?? '';
    $last_name = $_POST['last_name'] ?? '';
    $email = $_POST['email'] ?? '';
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($username) {
        $admin['first_name'] = $first_name;
        $admin['last_name'] = $last_name;
        $admin['email'] = $email;
        $admin['username'] = $username;
        $admin['password'] = $password;
        $admin['confirm_password'] = $_POST['confirm_password'];

        $result = db_insert_admin($admin);
        if ($result === true) {
            $id = $db->lastInsertId();
            $db = null;
            $_SESSION['status'] = 'Admin created';
            redirect_to('staff/admins/show.php?id=' . $id);
        } elseif (is_array($result)) {
            $error = $result;
        }
    }
}
?>


<?php $page_title = 'Create Admin'; ?>

<?php include(SHARED_PATH . '/head.php'); ?>

<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">

    <a class="back-link" href="<?php echo url_for('/staff/admins/index.php'); ?>">&laquo; Back to List</a>

    <div class="subject new">
        <h1>Create Admin</h1>

        <?php
        echo display_errors($error); ?>

        <form action="<?php echo (url_for('/staff/admins/new.php')) ?>" method="post">
            <dl>
                <dt>First name</dt>
                <dd><input type="text" name="first_name" value="<?php echo $first_name ?? ''; ?>" /></dd>
            </dl>
            <dl>
                <dt>Last name</dt>
                <dd><input type="text" name="last_name" value="<?php echo $last_name ?? ''; ?>" /></dd>
            </dl>
            <dl>
                <dt>Email</dt>
                <dd><input type="text" name="email" value="<?php echo $email ?? ''; ?>" /></dd>
            </dl>
            <dl>
                <dt>Username</dt>
                <dd><input type="text" name="username" value="<?php echo $username ?? ''; ?>" /></dd>
            </dl>
            <dl>
                <dt>Password</dt>
                <dd><input type="text" name="password" value="<?php echo $password ?? ''; ?>" /></dd>
            </dl>
            <dl>
                <dt>Comfirmed Password</dt>
                <dd><input type="text" name="confirm_password" value="" /></dd>
            </dl>
            <div id="operations">
                <input type="submit" value="Create Subject" />
            </div>
        </form>

    </div>

</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>