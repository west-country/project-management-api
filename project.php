<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

require 'src/DB.php';
require 'src/parameterFunctions.php';
require 'vendor/autoload.php';

use ProjectManagementApi\Exceptions\InvalidProjectIdException;
use ProjectManagementApi\Hydrators\ProjectHydrator;
use ProjectManagementApi\Response;

// try {

// try {
//     if (!array_key_exists('id', $_GET)) {
//         throw new InvalidProjectIdException("'id' expected in GET request");
//     }

if (!isset($_GET['id']) || !filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
    $response = new Response("Invalid project ID");
    $response->issueResponse(400);
} else {
    $project_id = $_GET['id'];
}

// if (isset($_GET['locale'])) {
//     $locale = strtoupper($_GET['locale']);
//     if ($locale !== "US" && $locale !== "UK") {
//         $response = new Response("Invalid locale");
//         $response->issueResponse(400);
//     }
// } else {
//     $locale = "UK";
// }

$locale = handleLocaleParameter($_GET['locale']);
// $locale = isset($_GET['locale']) ?
//     handleLocaleParameter($_GET['locale']) :
//     "UK";

$project = ProjectHydrator::getProjectById($pdo, $project_id, $locale);
print_r($project);

$response = new Response('Successfully retrieved project', $project);
$response->issueResponse(200);

    // } catch (InvalidProjectIdException $invalidProjectIdException) {
    //     $response = new Response('Invalid project ID', []);
    //     http_response_code(400);
    //     echo json_encode($response);
    // }
// } catch (Exception $exception) {
//     $response = new Response('Unexpected error', []);
//     http_response_code(500);
//     echo json_encode($response);
// }
