<?php

(new DotEnv(ROOT_DIR . '/.env'))->load();

$dsn = getenv('DSN');
$username = getenv('USERNAME');
$password = getenv('PASSWORD');

try {
    $db = new PDO($dsn, $username, $password);

} catch (PDOException $e) {
    $error = "Database Error: ";
    $error .= $e->getMessage();
    include 'view/error.php';
    exit();
}
