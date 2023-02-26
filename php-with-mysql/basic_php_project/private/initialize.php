<?php

ob_start();
session_start();

define('PRIVATE_PATH', dirname(__FILE__));
define('SHARED_PATH', PRIVATE_PATH . '/shared');
define('PROJECT_PATH', dirname(PRIVATE_PATH));
define('PUBLIC_PATH', PROJECT_PATH . '/public');

$public_position = strpos($_SERVER['SCRIPT_NAME'], '/public');
$doc_root = substr($_SERVER['SCRIPT_NAME'], 0, $public_position + 7);
define('WWW_ROOT', $doc_root);

require_once('functions.php');
require_once('database.php');
require_once('query_functions.php');
require_once('validation_functions.php');
require_once('auth_functions.php');

$db = db_connect();

?>