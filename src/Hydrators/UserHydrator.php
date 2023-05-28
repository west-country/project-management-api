<?php

namespace ProjectManagementApi\Hydrators;

use ProjectManagementApi\DatabaseConnection;
use ProjectManagementApi\Entities\User;

use PDO;

class UserHydrator
{
    public static function getUsersByProjectId(PDO $pdo, int $id): array
    {
        $pdoStmt = $pdo->prepare(
            'SELECT users.id, `name`, avatar, `role` '
                . 'FROM ProjectManagement.users JOIN project_users '
                . 'ON users.id = user_id '
                . 'WHERE project_id = :project_id'
        );
        $pdoStmt->bindParam('project_id', $id, PDO::PARAM_INT);
        $pdoStmt->execute();
        $users = $pdoStmt->fetchAll(PDO::FETCH_CLASS, User::Class);//|PDO::FETCH_PROPS_LATE
        return $users;
        // $userObjects = [];
        // foreach ($users as $userItem) {
        //     $userObject = new User(
        //         $userItem['id'],
        //         $userItem['name'],
        //         $userItem['avatar'],
        //         $userItem['role'],
        //     );
        //     $userObjects[] = $userObject;
        // }
    }
    // public static function getUsersByProjectId(DatabaseConnection $db, int $id): array
    // {
    //     $query = $db->prepare(
    //         'SELECT users.id, `name`, avatar, `role` '
    //             . 'FROM ProjectManagement.users JOIN project_users '
    //             . 'ON users.id = user_id '
    //             . 'WHERE project_id = :project_id'
    //     );
    //     $query->execute(['project_id' => $id]);
    //     $users = $query->fetchAll();
    //     $userObjects = [];
    //     foreach ($users as $userItem) {
    //         $userObject = new User(
    //             $userItem['id'],
    //             $userItem['name'],
    //             $userItem['avatar'],
    //             $userItem['role'],
    //         );
    //         $userObjects[] = $userObject;
    //     }
    //     return $userObjects;
    // }
}
