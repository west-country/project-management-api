<?php

namespace ProjectManagementApi\Hydrators;

use PDO;

use ProjectManagementApi\Entities\Task;

class TaskHydrator
{
    public static function getTasksByUserAndProjectId(PDO $pdo, int $user_id, int $project_id, bool $localeIsUSA = false)
    {
        $pdoStmt = $pdo->query("SELECT * FROM tasks WHERE user_id = :user_id AND project_id = :project_id");
        $pdoStmt->bindParam('user_id', $user_id, PDO::PARAM_INT);
        $pdoStmt->bindParam('project_id', $project_id, PDO::PARAM_INT);
        $pdoStmt->execute();
        $tasks = $pdoStmt->fetchAll(PDO::FETCH_CLASS, Task::Class);
        
        return $tasks;
    }
}

"id": "41",
"project_id": "1",
"user_id": "7",
"name": "curae",
"estimate": null, // only if locale=uk
"deadline": null,
"overdue": null
//  "estimate_hrs": null, // if locale=us
//  "estimate_days": null // if locale=us