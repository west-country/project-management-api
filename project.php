<?php

//header("Content-Type: text/plain");

require 'src/DB.php';
require 'vendor/autoload.php';

error_reporting(E_ALL);
ini_set("display_errors", 1);

use ProjectManagementApi\DB;
use ProjectManagementApi\DatabaseConnection;
use ProjectManagementApi\Exceptions\InvalidProjectIdException;
use ProjectManagementApi\Hydrators\ProjectHydrator;
use ProjectManagementApi\Response;

use ProjectManagementApi\Hydrators\UserHydrator; //


header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// try {
$db = new DatabaseConnection('mysql:localhost:3306; dbname=ProjectManagement;charset=utf8mb4', 'root', 'password');

// try {
//     if (!array_key_exists('id', $_GET)) {
//         throw new InvalidProjectIdException("'id' expected in GET request");
//     }
if (isset($_GET['id'])) {
    echo "id is set\n";
    //$project_id = $_GET['id'];
    if ( filter_var($_GET['id'], FILTER_VALIDATE_INT) !== false ) {
        $project_id = $_GET['id'];
        echo "id is int\n";
    }
}
if (!isset($_GET['id']) || !filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
    http_response_code(400);
    $response = new Response("Invalid project ID");
    $response = json_encode($response, JSON_PRETTY_PRINT);
    //echo $response;
    exit($response);
} else {
    $project_id = $_GET['id'];
}//EMPTY DATA ARRAY

if (array_key_exists('locale', $_GET)) {
    $locale = strtoupper($_GET['locale']);
    if ($locale == "US") {
        $localeIsUSA = true;
    } else if ($locale == "UK") {
        $localeIsUSA = false;
    } else {
        $response = new Response("Invalid locale");
        $response->issueResponse(400);
        // http_response_code(400);
        // $response = json_encode($response, JSON_PRETTY_PRINT);
        // exit($response);
    }
} else {
    $localeIsUSA = false;
}

//$users = UserHydrator::getUsersbyProjectId($pdo, $id);
$project = ProjectHydrator::getProjectById($pdo, $project_id, $localeIsUSA);
print_r($project);

$response = new Response('Successfully retrieved project', $project);
http_response_code(200);
$response = json_encode($response, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);


echo $response;

        // $project_id = $_GET['id'];

        // $project = ProjectHydrator::getProjectById($db, $project_id);
        // $projectAsAssociativeArray = $project->toAssociativeArrayAllProperties();

        // $response = new Response('Successfully retrieved project', $projectAsAssociativeArray);
        // http_response_code(200);
        // echo json_encode($response);
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
