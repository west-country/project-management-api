<?php

require 'src/DB.php';
require 'vendor/autoload.php';

error_reporting(E_ALL);
ini_set("display_errors", 1);

use ProjectManagementApi\Hydrators\ProjectHydrator;
use ProjectManagementApi\Response;

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

if (isset($_GET['id'])) {
    echo "id is set\n";
    if (filter_var($_GET['id'], FILTER_VALIDATE_INT) !== false) {
        $project_id = $_GET['id'];
        echo "id is int\n";
    }
}

// if (isset($_GET['locale'])) {
//     $locale = strtoupper($_GET['locale']);
//     switch ($locale) {
//         case "US":
//             $localeIsUSA = true;
//             break;
//         case "UK":
//             $localeIsUSA = false;
//             break;
//         default:
//             $response = new Response("Invalid locale");
//             $response->issueResponse(400);
//     }
// } else {
//     $localeIsUSA = false;
// }

if (isset($_GET['locale'])) {
    $locale = strtoupper($_GET['locale']);
    if ($locale !== "US" && $locale !== "UK") {
        $response = new Response("Invalid locale");
        $response->issueResponse(400);
    }
} else {
    $locale = "UK";
}

if (isset($_GET['client'])) {
    if (!filter_var($_GET['client'], FILTER_VALIDATE_INT)) {
        $response = new Response("Invalid client ID");
        $response->issueResponse(400);
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

// if (isset($_GET['id'])) {
//     if (!filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
//         $response = new Response("Invalid client ID");
//         $response->issueResponse(400);
//     } else {
//         $client_id = $_GET['id'];
//         $projectObjects = ProjectHydrator::getProjectsByClient($pdo, $client_id, $localeIsUSA);
//         print_r($projectObjects);

//         $response = new Response('Successfully retrieved project', $projectObjects);
//         $response->issueResponse(200);
//     }
// } else {
//     echo "is not set\n";
//     $projectObjects = ProjectHydrator::getAllProjects($pdo);
//     print_r($projectObjects);

//     $response = new Response('Successfully retrieved project', $projectObjects);
//     $response->issueResponse(200);
// }
// } catch (Exception $exception) {
//     $response = new Response('Unexpected error', []);
//     http_response_code(500);
//     echo json_encode($response);
// }
