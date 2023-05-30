<?php

namespace ProjectManagementApi;

use \PDO;
//use PDOException;
use \PDOException;
use ProjectManagementApi\Response;

require_once 'Response.php';
require_once 'src/handleErrors.php';
require 'vendor/autoload.php';

error_reporting(E_ALL);
ini_set("display_errors", 1);//0 for prod.

set_exception_handler('handleExceptions');

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

//try {
     $pdo = new \PDO($dsn, $user, $password, $options);
//} 
//catch (\PDOException $e) {
     //throw new PDOException($e->getMessage(), (int)$e->getCode());
     //throw new PDOException($e->getMessage(), (int)$e->getCode());
//}
