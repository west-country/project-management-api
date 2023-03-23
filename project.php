<?php

require 'vendor/autoload.php';

use ProjectManagementApi\Entities\Project;

use ProjectManagementApi\Hydrators\UserHydrator;
use ProjectManagementApi\DatabaseConnection;
use ProjectManagementApi\Response;
use ProjectManagementApi\Entities\User;

header('Content-Type: text/plain; charset=UTF-8');

$testUserArray = [];
$testUserOne = new User(1, 'name', 'avatar', 'role');
$testUserTwo = new User(2, 'name', 'avatar', 'role');
$testUserThree = new User(3, 'name', 'avatar', 'role');
array_push($testUserArray, $testUserOne, $testUserTwo, $testUserThree);
print_r($testUserArray);

// $db = new DatabaseConnection('mysql:host=db; dbname=project_manager', 'root', 'password');

// $dummyObjectsUserArray = UserHydrator::getUsersByProjectId($db, 6);

// print_r($dummyObjectsUserArray);

// $now = new DateTime();

// $newProject = new Project(1, 'name', 4, $now, 'client name', 'http://dummyimage.com/200x200.png/ff4444/ffffff', $dummyObjectsUserArray);

// $arrayOfUsers = $newProject->toAssociativeArrayAllProperties();

// $response = new Response('Sucessfully retrieved projects', $arrayOfUsers);

// http_response_code(200);
// echo json_encode($response);

