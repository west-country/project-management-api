<?php

namespace ProjectManagementApi\Hydrators;

// this is used in order to test that our code works

use DateTime;
use PDO; 

// because there is no DatabaseConnection class, we need to connect to the db
$db = new PDO('mysql:host=db; dbname=projectDB', 'root', 'password');
$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);


// use ProjectManagementApi\DatabaseConnection; this will be used, but currently refers to nothing
// use ProjectManagementApi\Entities\Project; as above

//this will be used above, but we have had to make the class in order to ensure our class works
class Project
{
    private int $id;
    private string $name;
    private string $client_id;
    private ?DateTime $deadline;

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
        $query = $db->prepare('SELECT id, `name`, client_id, deadline FROM projects');
        $query->execute();
        $projectsArray = $query->fetchAll();
        $projectObjectsArray = [];
        foreach ($projectsArray as $projectItem) {
            $project = new Project($projectItem['id'], $projectItem['name'], $projectItem['client_id'],  
            is_null($projectItem['deadline']) ? null : new DateTime($projectItem['deadline']));
            $projectObjectsArray[] = $project;
        }
        return $projectObjectsArray;
    }
}

//the below code was used to test the class, but will not be part of the final thing.
$databaseArray = ProjectHydrator::getAllProjects($db);
print_R($databaseArray);
