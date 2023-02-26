<?php
require_once(PRIVATE_PATH . '/db_credential.php');

function db_connect()
{
    $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];
    try {
        $pdo = new PDO($dsn, DB_USER, DB_PASSWORD, $options);
    } catch (PDOException $e) {
        exit($e->getMessage());
        throw new PDOException($e->getMessage(), (int) $e->getCode());
    }
    return $pdo;
}

function db_disconnect($pdo)
{
    if (isset($pdo)) {
        $pdo = null;
    }
}

/*
$stmt = $pdo->query('SELECT name FROM users');
while ($row = $stmt->fetch())
{
echo $row['name'] . "\n";
}
<?php
$dbh = new PDO('mysql:host=localhost;dbname=test', $user, $pass);
// use the connection here
$sth = $dbh->query('SELECT * FROM foo');
// and now we're done; close it
$sth = null;
$dbh = null;
?>
*/

?>