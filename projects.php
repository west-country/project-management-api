<?php

require 'vendor/autoload.php';

use ProjectManagementApi\DatabaseConnection;
use ProjectManagementApi\Hydrators\ProjectHydrator;
use ProjectManagementApi\Response;

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');


try {
    $db = new DatabaseConnection('mysql:host=db; dbname=project_manager', 'root', 'password');

    $projectObjectsArray = ProjectHydrator::getAllProjects($db);

    $arrayOfProjectsAsAssociativeArrays = [];
    foreach ($projectObjectsArray as $projectObject) {
        $arrayOfProjectsAsAssociativeArrays[] = $projectObject->toAssociativeArrayFewerProperties();
    }

    $response = new Response('Sucessfully retrieved projects', $arrayOfProjectsAsAssociativeArrays);
    http_response_code(200);
    echo json_encode($response);

} catch (Exception $exception) {
    $response = new Response('Unexpected error', []);
    http_response_code(500);
    echo json_encode($response);
}

