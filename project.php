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
require_once 'src/handleParameters.php';
require_once 'vendor/autoload.php';

use ProjectManagementApi\Hydrators\ProjectHydrator;
use ProjectManagementApi\Response;
use ProjectManagementApi\Exceptions\InvalidParameterException;

try {
    $locale = isset($_GET['locale']) ?
        handleLocaleParameter($_GET['locale']) :
        "UK";
    $project_id = handleRequiredNumericalParameter("id", "Invalid project ID");
    $project = ProjectHydrator::getProjectById($pdo, $project_id, $locale);
    $response = new Response('Successfully retrieved project', $project);
    $response->issueResponse(200);
} catch (InvalidParameterException $e) {
    $e->issueUserResponse();
}
