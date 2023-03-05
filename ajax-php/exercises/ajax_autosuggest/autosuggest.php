<?php
// You can simulate a slow server with sleep
// sleep(2);

function is_ajax_request()
{
  return isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
    $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
}

if (!is_ajax_request()) {
  exit;
}

$query = isset($_GET['q']) ? $_GET['q'] : '';
$query = strtolower($query);

function matchChoices($choice)
{
  global $query;

  return str_contains(strtolower($choice), $query);
}

function search($query, $choices)
{
  $result = array_filter($choices, "matchChoices");
  return $result;
}

// find and return search suggestions as JSON
$choices = file('includes/us_passenger_trains.txt', FILE_IGNORE_NEW_LINES);
$suggestions = search($query, $choices);

$max_items = 5;
sort($suggestions);

$top_suggestions = array_splice($suggestions, 0, 5);

echo json_encode($top_suggestions);

?>