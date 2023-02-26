<?php require_once('../../../private/initialize.php'); ?>

<?php require_login() ?>

<?php $page_title = 'Subject'; ?>

<?php

$subject_set = db_find_all_subjects();

?>

<?php include(SHARED_PATH . '/head.php'); ?>

<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">
  <div class="subjects listing">
    <h1>Subjects</h1>

    <div class="actions">
      <a class="action" href="<?php echo url_for('/staff/subjects/new.php') ?>">Create New Subject</a>
    </div>

    <p>
      <?php echo db_rows('subjects'); ?>
    </p>
    <table class="list">
      <tr>
        <th>ID</th>
        <th>Position</th>
        <th>Visible</th>
        <th>Name</th>
        <th>Pages</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
      </tr>

      <?php while ($subject = $subject_set->fetch()) { ?>
        <?php
        $count = db_count_pages_by_subject_id($subject['id']);

        $ordering_entry = db_subjectordering_by_subject_id($subject['id']);
        if (!$ordering_entry) {
          db_subjectordering_insert($subject['id'], 0);
          $ordering_entry = db_subjectordering_by_subject_id($subject['id']);
        }
        ?>
        <tr>
          <td>
            <?php echo $subject['id']; ?>
          </td>
          <td>
            <?php echo $ordering_entry['ordering']; ?>
          </td>
          <td>
            <?php echo $subject['visible'] == 1 ? 'true' : 'false'; ?>
          </td>
          <td>
            <?php echo $subject['menu_name']; ?>
          </td>
          <td>
            <?php echo $count; ?>
          </td>
          <td><a class="action" href="<?php
          echo url_for('/staff/subjects/show.php' . '?id=' . $subject['id']);
          ?>">View
            </a></td>
          <td><a class="action" href="<?php
          echo url_for('/staff/subjects/edit.php' . '?id=' . $subject['id']);
          ?>">Edit
            </a></td>
          <td><a class="action" href=" <?php
          echo url_for('/staff/subjects/delete.php' . '?id=' . $subject['id']);
          ?>">Delete></a></td>
        </tr>
      <?php } ?>
    </table>

  </div>

</div>

<?php $subject_set = null; ?>
<?php include(SHARED_PATH . '/staff_footer.php'); ?>