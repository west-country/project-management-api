<?php

//DEVELOPMENT
error_reporting(E_ALL);
ini_set("display_errors", 1);

//PRODUCTION
// ini_set('display_errors', 0);
// ini_set('log_errors', 1);

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

require_once 'src/DB.php';
require_once 'vendor/autoload.php';

use ProjectManagementApi\Hydrators\ClientHydrator;
use ProjectManagementApi\Response;

$clientObjects = ClientHydrator::getAllClients($pdo);
$response = new Response('Successfully retrieved clients', $clientObjects);
$response->issueResponse(200);
