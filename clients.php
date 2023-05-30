<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);//0 for prod.

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

require 'src/DB.php';
require 'vendor/autoload.php';

use ProjectManagementApi\Hydrators\ClientHydrator;
use ProjectManagementApi\Response;

{
    $clientObjects = ClientHydrator::getAllClients($pdo);
    $response = new Response('Successfully retrieved clients', $clientObjects);
    $response->issueResponse(200);
}