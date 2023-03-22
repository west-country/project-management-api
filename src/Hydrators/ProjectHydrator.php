<?php

namespace ProjectManagementApi\Hydrators;

use DateTime;

use ProjectManagementApi\DatabaseConnection; 
use ProjectManagementApi\Entities\Project; 

class ProjectHydrator
{
    public static function getAllProjects(DatabaseConnection $db)
    {
        $query = $db->prepare('SELECT id, `name`, client_id, deadline FROM projects');
        $query->execute();
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
