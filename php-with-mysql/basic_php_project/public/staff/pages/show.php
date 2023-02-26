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

if (isset($_GET['preview']) && $_GET['preview'] === 'true')
    $preview = true;
else
    $preview = false;
?>

<?php include(SHARED_PATH . '/head.php'); ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<p><a href="<?php echo url_for('/staff/subjects/show.php?id=' . $page['subject_id']) ?>">&laquo; Back to list</a></p>

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
<p>Content:</p>

<?php if ($preview) {
    echo strip_tags($page['content'], '<div><p><h1><ul><li>');
} else { ?>
    <textarea name="content" rows="10" cols="60">
                                        <?php echo uh($page['content']); ?>
                                    </textarea>
<?php } ?>

<div>
    <a href="<?php echo url_for('/staff/pages/show.php?id=' . $id . '&preview=false') ?>">Code</a>
</div>
<div>
    <a href="<?php echo url_for('/staff/pages/show.php?id=' . $id . '&preview=true') ?>">View</a>
</div>

<div>
    <a href="<?php echo url_for('/index.php?id=' . $id . '&preview=true') ?>" target="_blank">Preview</a>
</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>