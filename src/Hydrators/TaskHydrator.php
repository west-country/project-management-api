<?php

namespace ProjectManagementApi\Hydrators;

use PDO;
use ProjectManagementApi\Entities\Task;
use ProjectManagementApi\Response;
use ProjectManagementApi\Exceptions\NoDataException;


class TaskHydrator
{
    public static function getTasksByUserAndProjectId(PDO $pdo, int $user_id, int $project_id, string $locale): array
    {
        $pdoStmt = $pdo->prepare('SELECT * FROM ProjectManagement.tasks WHERE user_id = :user_id AND project_id = :project_id');
        $pdoStmt->execute(['user_id' => $user_id, 'project_id' => $project_id]);
        $tasks = $pdoStmt->fetchAll(PDO::FETCH_CLASS, Task::Class);

        if (!$tasks) {
            throw new NoDataException("No tasks assigned to that user for this project");
            // $response = new Response("No tasks assigned to that user for this project");
            // $response->issueResponse(404);
        }

        foreach ($tasks as $task) {
            // $task->handleLocale($locale);
            // $task->convertDeadlineToDatetime();
            // $task->__setIsOverdue();
            // $task->formatDeadline();

            $task->__setIsOverdue();
            $task->handleLocale($locale);
        }

        return $tasks;
    }

    public static function getTaskById(PDO $pdo, int $task_id, string $locale): Task
    {
        $pdoStmt = $pdo->prepare('SELECT * FROM ProjectManagement.tasks WHERE id = :task_id');
        $pdoStmt->execute(['task_id' => $task_id]);
        $task = $pdoStmt->fetchObject(Task::Class);

        if (!$task) {
            $response = new Response("Invalid task ID");
            $response->issueResponse(400);
        }

        // $task->handleLocale($locale);
        // $task->convertDeadlineToDatetime();
        // $task->__setIsOverdue();
        // $task->formatDeadline();

        $task->__setIsOverdue();
        $task->handleLocale($locale);

        return $task;
    }
}

//TASKS:
// "id": "41",
// "project_id": "1",
// "user_id": "7",
// "name": "curae",
// "estimate": null, // only if locale=uk
// "deadline": null,
// "overdue": null

//  "estimate_hrs": null, // if locale=us
//  "estimate_days": null // if locale=us