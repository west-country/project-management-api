<?php
require '../../../vendor/autoload.php';
use ProjectManagementApi\Hydrators\UserHydrator;
use ProjectManagementApi\DatabaseConnection;

$db = new DatabaseConnection('mysql:host=db; dbname=project_manager', 'root', 'password');

echo '<pre>';
print_r(UserHydrator::getUsersByProjectId($db, 6));
echo '</pre>';
