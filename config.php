<?php

ini_set('display_errors', 1);

$db = parse_url($_SERVER['CLEARDB_DATABASE_URL']);
$db['dbname'] = ltrim($db['path'], '/');
$dsn = "mysql:host={$db['host']};dbname={$db['dbname']};charset=utf8";
$user = $db['user'];
$password = $db['pass'];

define('DSN', "mysql:host={$db['host']};dbname={$db['dbname']};charset=utf8");
define('DB_USERNAME', $db['user']);
define('DB_PASSWORD', $db['pass']);