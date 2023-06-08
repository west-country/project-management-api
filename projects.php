<?php

require_once 'src/DB.php';
require_once 'src/handleParameters.php';
require_once 'src/handleErrors.php';
require 'vendor/autoload.php';

use ProjectManagementApi\Hydrators\ProjectHydrator;
use ProjectManagementApi\Response;
use ProjectManagementApi\Exceptions\InvalidParameterException;

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
