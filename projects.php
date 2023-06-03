<?php

require_once 'src/DB.php';
require_once 'src/handleParameters.php';
require_once 'vendor/autoload.php';

//DEVELOPMENT
error_reporting(E_ALL);
ini_set("display_errors", 1);

//PRODUCTION
// ini_set('display_errors', 0);
// ini_set('log_errors', 1);

use ProjectManagementApi\Exceptions\InvalidParameterException;
use ProjectManagementApi\Hydrators\ProjectHydrator;
use ProjectManagementApi\Response;

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

try {
    $locale = isset($_GET['locale']) ?
        handleLocaleParameter($_GET['locale']) :
        "UK";

    if (isset($_GET['client'])) {
        if (!filter_var($_GET['client'], FILTER_VALIDATE_INT)) {
            throw new InvalidParameterException("Invalid client ID");
        } else {
            $client_id = $_GET['client'];
            $projectObjects = ProjectHydrator::getProjectsByClient($pdo, $client_id, $locale);
            $response = new Response('Successfully retrieved project', $projectObjects);
            $response->issueResponse(200);
        }
    } else {
        $projectObjects = ProjectHydrator::getAllProjects($pdo, $locale);
        $response = new Response('Successfully retrieved projects', $projectObjects);
        $response->issueResponse(200);
    }
} catch (InvalidParameterException $e) {
    $e->issueUserResponse();
}
