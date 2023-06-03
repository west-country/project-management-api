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

use ProjectManagementApi\Hydrators\TaskHydrator;
use ProjectManagementApi\Response;
use ProjectManagementApi\Exceptions\InvalidParameterException;

try {
    $locale = isset($_GET['locale']) ?
        handleLocaleParameter($_GET['locale']) :
        "UK";
    $task_id = handleRequiredNumericalParameter("id", "Invalid task ID");
    $taskObject = TaskHydrator::getTaskById($pdo, $task_id, $locale);
    $response = new Response('Successfully retrieved task', $taskObject);
    $response->issueResponse(200);
} catch (InvalidParameterException $e) {
    $e->issueUserResponse();
}
