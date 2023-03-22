<?php

require 'vendor/autoload.php';

// these need to be deleted when the classes are created
use ProjectManagementApi\ProjectsDemo\Response;

use ProjectManagementApi\DatabaseConnection;
use ProjectManagementApi\Hydrators\ProjectHydrator;

try {
    //uncomment the line below and comment the line below that to tests error catching
    // $db = new DatabaseConnection('mysql:host=db; dbname=banana', 'root', 'password');
    $db = new DatabaseConnection('mysql:host=db; dbname=project_manager', 'root', 'password');

    $projectObjectsArray = ProjectHydrator::getAllProjects($db);

    $arrayOfProjectsAsAssociativeArrays = [];
    foreach ($projectObjectsArray as $projectObject) {
        $arrayOfProjectsAsAssociativeArrays[] = $projectObject->toAssociativeArrayFewerProperties();
    }

    $response = new Response('Sucessfully retrieved projects', $arrayOfProjectsAsAssociativeArrays);
    header('Content-Type: application/json');
    http_response_code(200);
    echo json_encode($response);

} catch (Exception $exception) {
    $response = new Response('Unexpected error', []);
    header('Content-Type: application/json');
    http_response_code(500);
    echo json_encode($response);
}

