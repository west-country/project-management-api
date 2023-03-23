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
        $queryProjectAndClient = $db->prepare('SELECT projects.id, projects.name, client_id, clients.name AS client_name, clients.logo AS client_logo, deadline 
                                                FROM projects INNER JOIN clients 
                                                ON client_id = clients.id 
                                                WHERE projects.id = :id');
        $queryProjectAndClient->execute(['id' => $id]);
        $projectArray = $queryProjectAndClient->fetch();
        if (empty($projectArray)) {
            throw new InvalidProjectIdException("Invalid project Id!");
        }
        $users = UserHydrator::getUsersbyProjectId($db, $id);
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
        return $project;
    }
}
