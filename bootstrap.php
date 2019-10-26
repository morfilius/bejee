<?php
require_once 'vendor/autoload.php';

$host = 'localhost';
$db   = 'beejee';
$user = 'root';
$pass = '';
$charset = 'utf8';

$dsn = "mysql:host=$host; dbname=$db; charset=$charset";
$opt = [
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

\app\Core\DB::getInstance()->connect($dsn, 'root', '', $opt);