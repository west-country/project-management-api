<?php

namespace ProjectManagementApi\Hydrators\ProjectHydratorDemo;

require '../../../vendor/autoload.php';

use PDO;

use ProjectManagementApi\Hydrators\ProjectHydrator;

$db = new PDO('mysql:host=db; dbname=projectDB', 'root', 'password');
$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

$databaseArray = ProjectHydrator::getAllProjects($db);
print_r($databaseArray);