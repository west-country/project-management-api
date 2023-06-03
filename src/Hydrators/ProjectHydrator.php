<?php

namespace ProjectManagementApi\Hydrators;

use PDO;
use ProjectManagementApi\Entities\Project;
use ProjectManagementApi\Hydrators\UserHydrator;
use ProjectManagementApi\Exceptions\NoDataException;

class ProjectHydrator
{
    public static function getAllProjects(PDO $pdo, string $locale): array
    {
        $pdoStmt = $pdo->query('SELECT id, `name`, client_id, deadline FROM projects');
        $projects = $pdoStmt->fetchAll(PDO::FETCH_CLASS, Project::Class);

        foreach ($projects as $project) {
            $project->__setIsOverdue();
            $project->handleLocale($locale);
        }
        return $projects;
    }

    public static function getProjectsByClient(PDO $pdo, int $id = null, string $locale): array
    {
        //try {
        $pdoStmt = $pdo->prepare('SELECT id, `name`, client_id, deadline 
        FROM projects WHERE client_id = :id');
        $pdoStmt->execute(['id' => $id]);
        $projects = $pdoStmt->fetchAll(PDO::FETCH_CLASS, Project::Class);
        // if (!$projects) {
        //         // $response = new Response("Invalid client ID");
        //         // $response->issueResponse(400);
        // }

        // if (!$projects) {
        //     throw new NoDataException("No projects for this client");
        // }

        foreach ($projects as $project) {
            // $project->convertDeadlineToDatetime();
            // $project->__setIsOverdue();
            // $project->formatDeadline($localeIsUSA);
            $project->__setIsOverdue();
            $project->handleLocale($locale);
        }
        return $projects;
        }

    public static function getProjectById(PDO $pdo, int $id, string $locale): Project
    {
        $pdoStmt = $pdo->prepare('SELECT projects.id, projects.name, client_id, clients.name AS client_name, clients.logo AS client_logo, deadline 
        FROM projects INNER JOIN clients 
        ON client_id = clients.id 
        WHERE projects.id = :id');
        $pdoStmt->bindParam('id', $id, PDO::PARAM_INT);
        $pdoStmt->execute();
        $project = $pdoStmt->fetchObject(Project::Class);

        // if (!$project) {
        //     $response = new Response("Invalid project ID");
        //     $response->issueResponse(400);
        // }

        // $project->convertDeadlineToDatetime();
        // $project->__setIsOverdue();
        // $project->formatDeadline($localeIsUSA);

        $project->__setIsOverdue();
        $project->handleLocale($locale);

        $users = UserHydrator::getUsersbyProjectId($pdo, $id);
        $project->__setUsers($users);
        return $project;
    }
}
