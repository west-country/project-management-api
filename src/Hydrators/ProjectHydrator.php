<?php

namespace ProjectManagementApi\Hydrators;

use PDO;
use DateTime;
use ProjectManagementApi\Entities\Project;
use ProjectManagementApi\Hydrators\UserHydrator;
use ProjectManagementApi\Exceptions\InvalidProjectIdException;

use ProjectManagementApi\Response;

class ProjectHydrator
{
    public static function getAllProjects(PDO $pdo, int $id = null, bool $localeIsUSA = false)
    {
        $pdoStmt = $pdo->query('SELECT id, `name`, client_id, deadline FROM ProjectManagement.projects');
        $projects = $pdoStmt->fetchAll(PDO::FETCH_CLASS, Project::Class);

        foreach ($projects as $project) {
            $project->convertDeadlineToDatetime();
            $project->__setIsOverdue();
            $project->formatDeadline($localeIsUSA);
            // $project?->convertDeadlineToDatetime()->__setIsOverdue()->formatDeadline($localeIsUSA);
        }
        return $projects;
    }

    public static function getProjectsByClient(PDO $pdo, int $id = null, bool $localeIsUSA = false)
    {
        $pdoStmt = $pdo->prepare('SELECT id, `name`, client_id, deadline 
        FROM ProjectManagement.projects WHERE client_id = :id');
        $pdoStmt->bindParam('id', $id, PDO::PARAM_INT);
        $pdoStmt->execute();
        $projects = $pdoStmt->fetchAll(PDO::FETCH_CLASS, Project::Class);
        if (!$projects) {
            //throw new InvalidProjectIdException("Invalid project Id!");
            $response = new Response("Invalid client ID");
            $response->issueResponse(400);
            // http_response_code(400);
            // $response = json_encode($response, JSON_PRETTY_PRINT);
            // exit($response);
        }

        foreach ($projects as $project) {
            $project->convertDeadlineToDatetime();
            $project->__setIsOverdue();
            $project->formatDeadline($localeIsUSA);
        }
        return $projects;
    }

    public static function getProjectById(PDO $pdo, int $id, bool $localeIsUSA = false)
    {
        $pdoStmt = $pdo->prepare('SELECT projects.id, projects.name, client_id, clients.name AS client_name, clients.logo AS client_logo, deadline 
        FROM ProjectManagement.projects INNER JOIN ProjectManagement.clients 
        ON client_id = clients.id 
        WHERE projects.id = :id');
        $pdoStmt->bindParam('id', $id, PDO::PARAM_INT);
        $pdoStmt->execute();
        $project = $pdoStmt->fetchObject(Project::Class);

        // if (empty($projectArray)) {
        //     throw new InvalidProjectIdException("Invalid project Id!");
        // }
        if (!$project) {
            // throw new InvalidProjectIdException("Invalid project Id!");
            $response = new Response("Invalid project ID");
            $response->issueResponse(400);
            // http_response_code(400);
            // $response = json_encode($response, JSON_PRETTY_PRINT);
            // exit($response);
        }

        $project->convertDeadlineToDatetime();
        $project->__setIsOverdue();
        $project->formatDeadline($localeIsUSA);
        $users = UserHydrator::getUsersbyProjectId($pdo, $id);
        $project->__setUsers($users);
        return $project;
    }
}
