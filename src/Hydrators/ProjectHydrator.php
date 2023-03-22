<?php

namespace ProjectManagementApi\Hydrators;
use PDO;

$db = new PDO('mysql:host=db; dbname=projectDB', 'root', 'password');

// use ProjectManagementApi\DatabaseConnection;
// use ProjectManagementApi\Entities\Project;
class Project 
{
    private int $id;
    private string $name;
    private string $client_id;
    private ?string $deadline;

    public function __construct($id, $name, $client_id, $deadline)
    {
        $this->id = $id;
        $this->name = $name;
        $this->client_id = $client_id;
        $this->deadline = $deadline;
    }
}

class ProjectHydrator 
{
    public static function getAllProjects($db)
    {
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $query = $db->prepare('SELECT id, name, client_id, deadline FROM projects');
        $query->execute();
        $projectsArray = $query->fetchAll();
        $projectObjectsArray=[];
        foreach($projectsArray as $projectItem) {
            $project = new Project($projectItem['id'], $projectItem['name'], $projectItem['client_id'], $projectItem['deadline']);
            $projectObjectsArray[] = $project;
        }
        return $projectObjectsArray;
    }
}

$databaseArray = ProjectHydrator :: getAllProjects($db);

print_R($databaseArray);