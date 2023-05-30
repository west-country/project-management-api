<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

require_once 'src/DB.php';
require_once 'src/handleParameters.php';
require 'vendor/autoload.php';

use ProjectManagementApi\Hydrators\ProjectHydrator;
use ProjectManagementApi\Response;
use ProjectManagementApi\Exceptions\InvalidParameterException;

try {
    // if (!isset($_GET['id']) || !filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
    //     $response = new Response("Invalid project ID");
    //     $response->issueResponse(400);
    // } else {
    //     $project_id = $_GET['id'];
    // }

    $locale = isset($_GET['locale']) ?
        handleLocaleParameter($_GET['locale']) :
        "UK";

    $project_id = handleRequiredNumericalParameter("id", "Invalid project ID");

    $project = ProjectHydrator::getProjectById($pdo, $project_id, $locale);
    $response = new Response('Successfully retrieved project', $project);
    $response->issueResponse(200);
} catch (InvalidParameterException $e) {
    $errorMessage = $e->getMessage();
    $response = new Response($errorMessage);
    $response->issueResponse(400);
}
