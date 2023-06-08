<?php

require_once 'Response.php';
require_once 'src/handleErrors.php';

$host = '127.0.0.1';
$db   = 'ProjectManagement';
$user = 'root';
$password = 'password';
$port = "3306";
$charset = 'utf8mb4';

$options = [
     \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
     \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
     \PDO::ATTR_EMULATE_PREPARES   => false,
];

$dsn = "mysql:host=$host;dbname=$db;charset=$charset;port=$port";
$pdo = new \PDO($dsn, $user, $password, $options);
