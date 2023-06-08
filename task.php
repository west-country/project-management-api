<?php

require_once 'src/DB.php';
require_once 'src/handleParameters.php';
require_once 'src/handleErrors.php';
require 'vendor/autoload.php';

use ProjectManagementApi\Hydrators\TaskHydrator;
use ProjectManagementApi\Response;
use ProjectManagementApi\Exceptions\InvalidParameterException;

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

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
