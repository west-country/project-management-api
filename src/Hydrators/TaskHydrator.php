<?php

namespace ProjectManagementApi\Hydrators;

use PDO;
use ProjectManagementApi\Entities\Task;
use ProjectManagementApi\Exceptions\NoDataException;

class TaskHydrator
{
    public static function getTasksByUserAndProjectId(PDO $pdo, int $user_id, int $project_id, string $locale): array
    {
        $pdoStmt = $pdo->prepare('SELECT * FROM tasks WHERE user_id = :user_id AND project_id = :project_id');
        $pdoStmt->execute(['user_id' => $user_id, 'project_id' => $project_id]);
        $tasks = $pdoStmt->fetchAll(PDO::FETCH_CLASS, Task::Class);
        if (!$tasks) {
            throw new NoDataException("No tasks assigned to that user for this project");
        }
        foreach ($tasks as $task) {
            $task->__setIsOverdue();
            $task->handleLocale($locale);
        }
        return $tasks;
    }

    public static function getTaskById(PDO $pdo, int $task_id, string $locale): Task
    {
        $pdoStmt = $pdo->prepare('SELECT * FROM tasks WHERE id = :task_id');
        $pdoStmt->execute(['task_id' => $task_id]);
        $task = $pdoStmt->fetchObject(Task::Class);
        $task->__setIsOverdue();
        $task->handleLocale($locale);
        return $task;
    }
}
