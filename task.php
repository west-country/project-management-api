<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

require 'src/DB.php';
require 'src/handleParameters.php';
require 'vendor/autoload.php';

use ProjectManagementApi\Hydrators\TaskHydrator;
use ProjectManagementApi\Response;
use ProjectManagementApi\Exceptions\InvalidParameterException;

// if (isset($_GET['locale'])) {
//     $locale = strtoupper($_GET['locale']);
//     if ($locale !== "US" && $locale !== "UK") {
//         $response = new Response("Invalid locale");
//         $response->issueResponse(400);
//     }
// } else {
//     $locale = "UK";
// }
try {
$locale = isset($_GET['locale']) ?
        handleLocaleParameter($_GET['locale']) :
        "UK";

// if (!isset($_GET['id']) || !filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
//     $response = new Response("Invalid task ID");
//     $response->issueResponse(400);
// } else {
//     $task_id = $_GET['id'];
// }
$task_id = handleRequiredNumericalParameter("id", "Invalid task ID");

$taskObject = TaskHydrator::getTaskById($pdo, $task_id, $locale);
//print_r($taskObject);
$response = new Response('Successfully retrieved task', $taskObject);
$response->issueResponse(200);
}
catch (InvalidParameterException $e) {
    $errorMessage = $e->getMessage();
    $response = new Response($errorMessage);
    $response->issueResponse(400);
}