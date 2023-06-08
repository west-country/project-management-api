<?php

require_once 'src/DB.php';
require_once 'src/handleErrors.php';
require_once 'vendor/autoload.php';

use ProjectManagementApi\Hydrators\ClientHydrator;
use ProjectManagementApi\Response;

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$clientObjects = ClientHydrator::getAllClients($pdo);
$response = new Response('Successfully retrieved clients', $clientObjects);
$response->issueResponse(200);
