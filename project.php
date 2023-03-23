<?php

require 'vendor/autoload.php';

use ProjectManagementApi\DatabaseConnection;
use ProjectManagementApi\Exceptions\InvalidProjectIdException;
use ProjectManagementApi\Hydrators\ProjectHydrator;
use ProjectManagementApi\Response;

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

try {
    $db = new DatabaseConnection('mysql:host=db; dbname=project_manager', 'root', 'password');

    try {
        if (!array_key_exists('id', $_GET)) {
            throw new InvalidProjectIdException("'id' expected in GET request");
        }

        $project_id = $_GET['id'];

        $project = ProjectHydrator::getProjectById($db, $project_id);
        $projectAsAssociativeArray = $project->toAssociativeArrayAllProperties();

        $response = new Response('Successfully retrieved project', $projectAsAssociativeArray);
        http_response_code(200);
        echo json_encode($response);
    } catch (InvalidProjectIdException $invalidProjectIdException) {
        $response = new Response('Invalid project ID', []);
        http_response_code(400);
        echo json_encode($response);
    }
} catch (Exception $exception) {
    $response = new Response('Unexpected error', []);
    http_response_code(500);
    echo json_encode($response);
}
