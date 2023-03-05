<?php
// You can simulate a slow server with sleep
sleep(1);

function is_ajax_request()
{
  return isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
    $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
}

$length = isset($_POST['length']) ? (int) $_POST['length'] : '';
$width = isset($_POST['width']) ? (int) $_POST['width'] : '';
$height = isset($_POST['height']) ? (int) $_POST['height'] : '';

$errors = [];
if (!$length)
  $errors[] = 'length';
if (!$width)
  $errors[] = 'width';
if (!$height)
  $errors[] = 'height';

if (!empty($errors)) {
  if (is_ajax_request()) {
    echo json_encode(["errors" => $errors]);
  } else {
    echo 'Invalid input for: ' . implode(', ', $errors);
    echo '<p><a href="index.php">Back</a></p>';
  }
  exit;
}

$volume = $length * $width * $height;

if (is_ajax_request()) {
  echo json_encode(['volume' => $volume]);
} else {
  echo 'Form submitted ' . $volume;
  echo '<p><a href="index.php">Back</a></p>';
}

?>