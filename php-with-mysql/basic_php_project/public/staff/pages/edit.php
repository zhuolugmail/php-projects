<?php require_once('../../../private/initialize.php'); ?>

<?php require_login() ?>

<?php include(SHARED_PATH . '/head.php'); ?>

<?php
if (!isset($_GET['id'])) {
    redirect_to('/staff/pages/new.php');
} else {
    $id = $_GET['id'];
}
?>

<?php

$page_set = db_find_page($id);


$subject_set = db_find_all_subjects();

$menu = $page_set['menu_name'];

$subject_id = $page_set['subject_id'];
$visible = $page_set['visible'];
$content = $page_set['content'];

$count = db_pageordering_max_ordering($subject_id);
$ordering_entry = db_pageordering_by_page_id($subject_id, $id);
$position = $ordering_entry['ordering'];

$error = [];

if (is_post_request()) {
    $menu = $_POST['menu'] ?? '';
    $subject_id = $_POST['subject_id'] ?? '';
    $position = $_POST['position'] ?? $position;
    $visible = $_POST['visible'] ?? 0;
    $content = $_POST['content'] ?? '';

    $result = db_update_page($id, $menu, $subject_id, $position, $visible, $content);
    if ($result === true) {

        db_pageordering_update($subject_id, $id, $position);

        $db = null;
        $_SESSION['status'] = 'Page updated';
        redirect_to('staff/pages/show.php?id=' . $id);
    } elseif (is_array($result))
        $error = $result;
}

?>

<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">
    <p><a href="<?php echo url_for('/staff/subjects/show.php?id=' . $page_set['subject_id']) ?>">&laquo; Back to
            list</a></p>

    <?php
    echo display_errors($error); ?>

    <form action="<?php echo url_for('/staff/pages/edit.php?id=' . $id) ?>" method="post">
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
                echo '>' . $subject['menu_name'] . '</option>\n';
            }
            ?>
        </select><br><br>
        <label for="position">Position:</label>
        <select name="position">
            <?php for ($i = 1; $i <= $count; $i++) {
                echo '<option value="';
                echo $i . '"';
                if ($i == $position)
                    echo ' selected';
                echo '>' . $i . '</option>\n';
            }
            ?>
        </select><br><br>
        <label for="visible">Visible:</label>
        <input type="hidden" name="visible" value="0" />
        <input type="checkbox" name="visible" value="1" <?php echo ($visible ? 'checked' : '') ?> /><br><br>
        <textarea name="content" rows="10" cols="60"> <?php echo uh($content) ?> </textarea> <input type="submit"
            value="Submit">
    </form>

</div>


<?php $subject_set = null ?>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>