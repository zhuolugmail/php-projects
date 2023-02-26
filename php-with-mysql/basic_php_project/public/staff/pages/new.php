<?php require_once('../../../private/initialize.php'); ?>

<?php require_login() ?>

<?php include(SHARED_PATH . '/head.php'); ?>

<?php

$subject_set = db_find_all_subjects();

$subject_id = $_GET['subject_id'] ?? '';

$count = db_pageordering_max_ordering($subject_id);

$menu = '';
$position = $count + 1;
$visible = '';
$content = '';

$error = [];

if (is_post_request()) {
    $menu = $_POST['menu'] ?? '';
    $subject_id = $_POST['subject_id'] ?? '';
    $position = $_POST['position'] ?? $position;
    $visible = $_POST['visible'] ?? 0;
    $content = $_POST['content'] ?? '';

    $result = db_insert_page($menu, $subject_id, $position, $visible, $content);
    if ($result === true) {
        $id = $db->lastInsertId();

        db_pageordering_insert($subject_id, $id, $position);

        $db = null;
        $_SESSION['status'] = 'Page created';
        redirect_to('staff/pages/show.php?id=' . $id);
    } elseif (is_array($result))
        $error = $result;
}
?>

<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">

    <?php
    echo display_errors($error);
    ?>

    <a class="back-link" href="<?php echo url_for('/staff/subjects/index.php?id=' . $subject_id); ?>">&laquo; Back to
        List</a>

    <form action="<?php echo url_for('/staff/pages/new.php') ?>" method="post">
        <label for="menu">Menu:</label>
        <input type="text" name="menu" value="<?php echo $menu ?>"><br><br>
        <label for="subject">Subject:</label>
        <select name="subject_id">
            <?php
            while ($subject = $subject_set->fetch()) {
                echo '<option value="';
                echo $subject['id'] . '"';
                if ($subject['id'] == $subject_id)
                    echo ' selected';
                echo '>' . $subject['menu_name'] . '</option>';
            }
            ?>
        </select><br><br>
        <label for="position">Position:</label>
        <select name="position">
            <?php for ($i = 1; $i <= $position; $i++) {
                echo '<option value="';
                echo $i . '"';
                if ($i == $position)
                    echo ' selected';
                echo '>' . $i . '</option>';
            }
            ?>
        </select><br><br>
        <label for="visible">Visible:</label>
        <input type="hidden" name="visible" value="0" />
        <input type="checkbox" name="visible" value="1" <?php echo ($visible ? 'checked' : '') ?> /><br><br>
        <input type="text" name="content" value="<?php echo $content ?>">
        <input type="submit" value="Submit">
    </form>

</div>

<?php $subject_set = null ?>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>