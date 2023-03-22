<?php

namespace ProjectManagementApi\Hydrators;

use ProjectManagementApi\DatabaseConnection;
use ProjectManagementApi\Entities\Project;

class ProjectHydrator 
{
    public static function getAllProjects(DatabaseConnection $db)
    {
        $query = $db->prepare('SELECT id, "name", client_id, deadline FROM projects');
        $query->execute();
        $query->fetchAll();
    }
}