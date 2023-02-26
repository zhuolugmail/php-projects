<navigation>
  <?php
  if (!$preview)
    $opts1 = ['visible' => 1];
  else
    $opts1 = [];
  $nav_subjects = db_find_all_subjects(opts: $opts1); ?>
  <ul class="subjects">
    <?php while ($nav_subject = $nav_subjects->fetch()) { ?>

      <?php
      $nav_pages = db_find_pages_by_subject_id(
        $nav_subject['id'],
      opts: $opts1
      ); ?>
      <?php
      $n_pages = [];
      while ($nav_page = $nav_pages->fetch()) {
        $n_pages[] = $nav_page;
      } // while $nav_pages ?>

      <li <?php
      if ($nav_subject['id'] == $subject_id)
        echo ' class="selected"';
      ?>>
        <?php if ($n_pages) { ?>
          <a href="<?php echo url_for('index.php') . '?id=' . $n_pages[0]['id']; ?>">
          <?php } else { ?>
            <a href="<?php echo url_for('index.php'); ?>">
            <?php } ?>
            <?php echo h($nav_subject['menu_name']); ?>
          </a>
      </li>

      <?php if ($nav_subject['id'] == $subject_id) { ?>

        <ul class="subjects">

          <?php foreach ($n_pages as $nav_page) { ?>
            <li <?php if ($nav_page['id'] == $id)
              echo ' class="selected"'; ?>>
              <a href="<?php echo url_for('index.php') . '?id=' . $nav_page['id']; ?>">
                <?php echo h($nav_page['menu_name']); ?>
              </a>
            </li>
          <?php } /* foreach ($n_pages as $nav_page) */?>

        </ul>

      <?php } /* if ($nav_subject['id'] == $subject_id) */?>


    <?php } // while $nav_subjects ?>
  </ul>
  <?php $nav_subjects = null; ?>
</navigation>