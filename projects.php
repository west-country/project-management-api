<?php

require 'vendor/autoload.php';

use ProjectManagementApi\DatabaseConnection;
use ProjectManagementApi\Hydrators\ProjectHydrator;
use ProjectManagementApi\Response;

try {
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

