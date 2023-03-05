<?php
// You can simulate a slow server with sleep
// sleep(2);

session_start();

if (!isset($_SESSION['favorites'])) {
  $_SESSION['favorites'] = [];
}

function is_ajax_request()
{
  return isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
    $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
}

if (!is_ajax_request()) {
  exit;
}

// extract $id
$id = $_POST['id'] ?? '';
$value = $_POST['value'] ?? '0';

// store in $_SESSION['favorites']
if ($value) {
  if (in_array($id, $_SESSION['favorites']))
    echo 'false';
  else {
    $_SESSION['favorites'][] = $id;
    echo 'true';
  }
} else {
  $index = array_search($id, $_SESSION['favorites']);
  if ($index === false) {
  } else {
    unset($_SESSION['favorites'][$index]);
  }
  echo 'false';
}

// return true/false

?>