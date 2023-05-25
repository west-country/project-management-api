<?php
// mysql:localhost:3306; dbname=ProjectManagement;charset=utf8mb4', 'root', 'password'

namespace ProjectManagementApi;

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

try {
     $pdo = new \PDO($dsn, $user, $password, $options);
} catch (\PDOException $e) {
     throw new \PDOException($e->getMessage(), (int)$e->getCode());
     http_response_code(500);
     $response = new Response("Unexpected error");
     $response = json_encode($response, JSON_PRETTY_PRINT);
     exit($response);
}
