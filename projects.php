<?php

require 'src/DB.php';
require 'src/handleParameters.php';
require 'vendor/autoload.php';

//DEVELOPMENT
error_reporting(E_ALL);
ini_set("display_errors", 1);
//ini_set('log_errors', 1);

//PRODUCTION
// ini_set('display_errors', 0);
// ini_set('log_errors', 1);

use ProjectManagementApi\Exceptions\InvalidParameterException;
use ProjectManagementApi\Hydrators\ProjectHydrator;
use ProjectManagementApi\Response;
use ProjectManagementApi\Exceptions\InvalidProjectIdException;


use ProjectManagementApi\PDOException;

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

try {
    $locale = isset($_GET['locale']) ?
        handleLocaleParameter($_GET['locale']) :
        "UK";

    // if (isset($_GET['client'])) {
    //     if (!filter_var($_GET['client'], FILTER_VALIDATE_INT)) {
    //         $response = new Response("Invalid client ID");
    //         $response->issueResponse(400);
    //     } else {
    //         $client_id = $_GET['client'];
    //         $projectObjects = ProjectHydrator::getProjectsByClient($pdo, $client_id, $locale);
    //         $response = new Response('Successfully retrieved project', $projectObjects);
    //         $response->issueResponse(200);
    //     }
    // } else {
    //     $projectObjects = ProjectHydrator::getAllProjects($pdo, $locale);
    //     $response = new Response('Successfully retrieved projects', $projectObjects);
    //     $response->issueResponse(200);
    // }

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
    $errorMessage = $e->getMessage();
    $response = new Response($errorMessage);
    $response->issueResponse(400);
}
