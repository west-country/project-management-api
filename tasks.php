<?php

require_once 'src/DB.php';
require_once 'src/handleParameters.php';
require_once 'src/handleErrors.php';
require 'vendor/autoload.php';

use ProjectManagementApi\Hydrators\TaskHydrator;
use ProjectManagementApi\Response;
use ProjectManagementApi\Exceptions\InvalidParameterException;
use ProjectManagementApi\Exceptions\NoDataException;

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

try {
    $locale = isset($_GET['locale']) ?
        handleLocaleParameter($_GET['locale']) :
        "UK";

    $requiredParameters = array('user_id' => 'Invalid user ID', 'project_id' => 'Invalid project ID');

    foreach ($requiredParameters as $parameter => $errorMessage) {
        $$parameter = handleRequiredNumericalParameter($parameter, $errorMessage);
    }

    $taskObjects = TaskHydrator::getTasksByUserAndProjectId($pdo, $user_id, $project_id, $locale);
    $response = new Response('Successfully retrieved tasks', $taskObjects);
    $response->issueResponse(200);
} catch (InvalidParameterException $e) {
    $e->issueUserResponse();
} catch (NoDataException $e) {
    $e->issueUserResponse();
}
