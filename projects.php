<?php

require 'vendor/autoload.php';

// these need to be deleted when the classes are created
use ProjectManagementApi\ProjectsDemo\Project;

use ProjectManagementApi\DatabaseConnection;
use ProjectManagementApi\Hydrators\ProjectHydrator;

$db = new DatabaseConnection('mysql:host=db; dbname=projectDB', 'root', 'password');

$projectObjectsArray = ProjectHydrator::getAllProjects($db);

$projectsAsAssocArrays = [];
foreach ($projectObjectsArray as $projectObject) {
    $projectsAsAssocArrays[] = $projectObject->toAssociativeArrayFewerProperties();
}

// FIXME send response
