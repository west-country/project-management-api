<?php

namespace ProjectManagementApi\Hydrators;

use DateTime;

use ProjectManagementApi\DatabaseConnection; 
use ProjectManagementApi\Entities\Project; 

class ProjectHydrator
{
    public static function getAllProjects(DatabaseConnection $db)
    {
        $query = $db->query('SELECT id, `name`, client_id, deadline FROM projects');
        $projectsArray = $query->fetchAll();
        $projectObjectsArray = [];
        foreach ($projectsArray as $projectItem) {
            $projectObject = new Project(
                $projectItem['id'],
                $projectItem['name'],
                $projectItem['client_id'],
                is_null($projectItem['deadline']) ? null : new DateTime($projectItem['deadline'])
            );
            $projectObjectsArray[] = $projectObject;
        }
        return $projectObjectsArray;
    }
}
