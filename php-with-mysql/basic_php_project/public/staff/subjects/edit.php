<?php require_once('../../../private/initialize.php'); ?>

<?php require_login() ?>

<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    redirect_to('/staff/subjects/new.php');
}

$error = [];

if (is_post_request()) {
    $menu_name = $_POST['menu_name'] ?? '';
    $position = $_POST['position'] ?? '';
    $visible = $_POST['visible'] ?? '';

    $result = db_update_subject($id, $menu_name, $position, $visible);
    if ($result === true) {

        db_subjectordering_update($id, $position);

        $db = null;
        $_SESSION['status'] = 'Subject updated';
        redirect_to('staff/subjects/show.php?id=' . $id);
    } elseif (is_array($result))
        $error = $result;
} else {
    $subject = db_find_subject($id);
    $menu_name = $subject['menu_name'];
    $position = $subject['position'];
    $visible = $subject['visible'];
}
$count = db_rows('subjects');
?>

<?php $page_title = 'Edit Subject'; ?>

<?php include(SHARED_PATH . '/head.php'); ?>

<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">

    <a class="back-link" href="<?php echo url_for('/staff/subjects/index.php'); ?>">&laquo; Back to List</a>

    <div class="subject edit">
        <h1>Edit Subject</h1>

        <?php
        echo display_errors($error); ?>


        <form action="<?php echo url_for('staff/subjects/edit.php?id=' . $id) ?>" method="post">
            <dl>
                <dt>Menu Name</dt>
                <dd><input type="text" name="menu_name" value="<?php echo $menu_name ?>" /></dd>
            </dl>
            <dl>
                <dt>Position</dt>
                <dd>
                    <select name="position">
                        <?php for ($i = 1; $i <= $count; $i++) {
                            echo '<option value="' . $i . '"';
                            echo $position == $i ? ' selected' : '';
                            echo '>' . $i . '</option>';
                        }
                        ?>
                    </select>
                </dd>
            </dl>
            <dl>
                <dt>Visible</dt>
                <dd>
                    <input type="hidden" name="visible" value="0" />
                    <input type="checkbox" name="visible" value="1" />
                </dd>
            </dl>
            <div id="operations">
                <input type="submit" value="Edit Subject" />
            </div>
        </form>

    </div>

</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>