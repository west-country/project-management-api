<?php

namespace ProjectManagementApi\Hydrators;

use DateTime;

use ProjectManagementApi\DatabaseConnection;
use ProjectManagementApi\Entities\Project;
use ProjectManagementApi\Hydrators\UserHydrator;
use ProjectManagementApi\Exceptions\InvalidProjectIdException;

class ProjectHydrator
{
    public static function getAllProjects(DatabaseConnection $db)
    {
        $query = $db->query('SELECT id, `name`, client_id, deadline FROM projects');
        $projects = $query->fetchAll();
        $projectObjects = [];
        foreach ($projects as $projectItem) {
            $projectObject = new Project(
                $projectItem['id'],
                $projectItem['name'],
                $projectItem['client_id'],
                $projectItem['deadline']
            );
            $projectObjects[] = $projectObject;
        }
        return $projectObjects;
    }

    public static function getProjectById(DatabaseConnection $db, int $id)
    {
        // as discussed with Amyas, the id referred to by select is ambigious and may confuse the query, so projects.id would remove the ambiguity
        $queryProjectAndClient = $db->prepare('SELECT id, `name`, client_id, client_name, client_logo, deadline 
                            FROM projects INNER JOIN clients 
                            ON projects.client_id = clients.id 
                            WHERE id=:id');
                            // for above - same as the other comment
        $queryProjectAndClient->execute(['id' => $id]);
        $projectArray = $queryProjectAndClient->fetch();
        if($projectArray === []) {
            throw new InvalidProjectIdException; 
        }
        $users = UserHydrator::getUsersbyProjectId($id);
        $projectArray['users'] = $users;
        
        $project = new Project(
                    $projectArray['id'], 
                    $projectArray['name'],
                    $projectArray['client_id'],
                    $projectArray['deadline'],
                    $projectArray['client_name'],
                    $projectArray['client_logo'], 
                    $projectArray['users']
                    );
        return($project);
    }
}
