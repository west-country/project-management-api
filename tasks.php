<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);//0 for prod.

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

require 'src/DB.php';
require 'vendor/autoload.php';

use ProjectManagementApi\Hydrators\TaskHydrator;
use ProjectManagementApi\Response;

// `user_id=[numeric]`

// `project_id=[numeric]`

// **Optional:**

// `locale=[uk|us]`
if (isset($_GET['locale'])) {
    $locale = strtoupper($_GET['locale']);
    if ($locale !== "US" && $locale !== "UK") {
        $response = new Response("Invalid locale");
        $response->issueResponse(400);
    }
} else {
    $locale = "UK";
}

$requiredParameters = array('user_id' => 'Invalid user ID', 'project_id' => 'Invalid project ID');

foreach ($requiredParameters as $parameter => $errorMessage) {
    if (isset($_GET[$parameter])) {
        if (!filter_var($_GET[$parameter], FILTER_VALIDATE_INT)) {
            $response = new Response($errorMessage);
            $response->issueResponse(400);
        } else {
            $$parameter = $_GET[$parameter];
        }
    } else {
        $response = new Response($errorMessage);
        $response->issueResponse(400);
    }
}

$taskObjects = TaskHydrator::getTasksByUserAndProjectId($pdo, $user_id, $project_id, $locale);
print_r($taskObjects);
$response = new Response('Successfully retrieved tasks', $taskObjects);
$response->issueResponse(200);
