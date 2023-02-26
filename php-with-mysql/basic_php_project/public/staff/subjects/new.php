<?php require_once('../../../private/initialize.php'); ?>

<?php require_login() ?>

<?php

$menu_name = '';
$visible = '';

$count = db_rows('subjects') + 1;

$error = [];

// Handle form values sent by new.php
if (is_post_request()) {
    $menu_name = $_POST['menu_name'] ?? '';
    $position = $_POST['position'] ?? '';
    $visible = $_POST['visible'] ?? '';

    if ($menu_name) {
        $result = db_insert_subject($menu_name, $position, $visible);
        if ($result === true) {
            $id = $db->lastInsertId();

            db_subjectordering_insert($id, $position);

            $db = null;
            $_SESSION['status'] = 'Subject created';
            redirect_to('staff/subjects/show.php?id=' . $id);
        } elseif (is_array($result)) {
            $error = $result;
        }
    }
} else {
    $position = $count;
}
?>


<?php $page_title = 'Create Subject'; ?>

<?php include(SHARED_PATH . '/head.php'); ?>

<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">

    <a class="back-link" href="<?php echo url_for('/staff/subjects/index.php'); ?>">&laquo; Back to List</a>

    <div class="subject new">
        <h1>Create Subject</h1>

        <?php
        echo display_errors($error); ?>

        <form action="<?php echo (url_for('/staff/subjects/new.php')) ?>" method="post">
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
                    <input type="checkbox" name="visible" value="1" <?php echo $visible ? 'checked' : '' ?> />
                </dd>
            </dl>
            <div id="operations">
                <input type="submit" value="Create Subject" />
            </div>
        </form>

    </div>

</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>