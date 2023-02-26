<?php

require_once('../../../private/initialize.php');

$id = uh($_GET['id'] ?? 1);
$subject = db_find_subject($id);

$ordering_entry = db_subjectordering_by_subject_id($id);

$pages_set = db_find_pages_by_subject_id($id);

$page_title = 'Subject: ' . $subject['menu_name'];
?>

<?php require_login() ?>

<?php include(SHARED_PATH . '/head.php'); ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<p>
    <span style="strong">Id: </span>
    <?php echo $subject['id']; ?>
</p>
<p>
    <span style="strong">menu_name: </span>
    <?php echo $subject['menu_name']; ?>
</p>
<p>
    <span style="strong">Position: </span>
    <?php echo $ordering_entry['ordering']; ?>
</p>
<p>
    <span style="strong">Visible: </span>
    <?php echo $subject['visible'] == 1 ? 'true' : 'false'; ?>
</p>

<hr>

<div class="pages listing">
    <h1>Pages</h1>

    <div class="actions">
        <a class="action" href="<?php echo url_for('staff/pages/new.php?subject_id=' . $id) ?>">Create New Page</a>
    </div>

    <table class="list">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Position</th>
            <th>Visible</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
        </tr>

        <?php while ($page = $pages_set->fetch()) { ?>
            <?php $ordering_entry = db_pageordering_by_page_id($subject['id'], $page['id']);
            if (!$ordering_entry) {
                db_pageordering_insert($subject['id'], $page['id'], 0);
                $ordering_entry = db_pageordering_by_page_id($subject['id'], $page['id']);
            }
            ?>
            <tr>
                <td>
                    <?php echo $page['id']; ?>
                </td>
                <td>
                    <?php echo $page['menu_name']; ?>
                </td>
                <td>
                    <?php echo $ordering_entry['ordering']; ?>
                </td>
                <td>
                    <?php echo $page['visible'] == 1 ? 'true' : 'false'; ?>
                </td>
                <td><a class="action" href="<?php
                echo url_for('/staff/pages/show.php' . '?id=' . $page['id']);
                ?>">View
                    </a></td>
                <td><a class="action" href="<?php
                echo url_for('/staff/pages/edit.php' . '?id=' . $page['id']);
                ?>">Edit
                    </a></td>
                <td><a class="action" href="<?php
                echo url_for('/staff/pages/delete.php' . '?id=' . $page['id']);
                ?>">Delete></a></td>
            </tr>
        <?php } ?>
    </table>
</div>

<?php $pages_set = null; ?>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>