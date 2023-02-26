<?php require_once('../../../private/initialize.php'); ?>

<?php require_login() ?>

<?php
if (!isset($_GET['id'])) {
    $db = null;
    redirect_to('/staff/pages/index.php');
}
$id = $_GET['id'];
$page = db_find_page($id);
$subject = db_find_subject($page['subject_id']);
$page_title = 'Page';

if (is_post_request()) {
    $result = db_delete_page($id);
    if ($result) {

        db_pageordering_delete($page['subject_id'], $id);

        $db = null;
        $_SESSION['status'] = 'Page deleted';
        redirect_to('/staff/subjects/show.php?id=' . $page['subject_id']);
    }
}
?>

<?php include(SHARED_PATH . '/head.php'); ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<p><a href="<?php echo url_for('/staff/subjects/index.php?id=' . $page['subject_id']) ?>">&laquo; Back to list</a></p>

<h2>Page
    <?php echo $id . ': ' . $page['menu_name']; ?>
</h2>
<p>Subject:
    <?php echo $subject['menu_name']; ?>
</p>
<p>Position:
    <?php echo $page['position']; ?>
</p>
<p>Visible:
    <?php echo $page['visible']; ?>
</p>
<p>Content:
    <?php echo $page['content']; ?>
</p>

<p>Are you sure you want to delete this page?</p>

<form action="<?php echo url_for('/staff/pages/delete.php?id=' . h(u($id))); ?>" method="post">
    <div id="operations">
        <input type="submit" name="commit" value="Delete Page" />
    </div>
</form>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>