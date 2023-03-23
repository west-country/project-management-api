<?php

namespace ProjectManagementApi\Hydrators;

use ProjectManagementApi\DatabaseConnection;
use ProjectManagementApi\Entities\User;

class UserHydrator
{
    public static function getUsersByProjectId(DatabaseConnection $db, int $id): array
    {
        $query = $db->prepare(
            'SELECT users.id, `name`, avatar, `role` '
                . 'FROM users JOIN project_users '
                . 'ON users.id = user_id AND project_id = :project_id'
        );
        $query->execute(['project_id' => $id]);
        $users = $query->fetchAll();
        $userObjects = [];
        foreach ($users as $userItem) {
            $userObject = new User(
                $userItem['id'],
                $userItem['name'],
                $userItem['avatar'],
                $userItem['role'],
            );
            $userObjects[] = $userObject;
        }
        return $userObjects;
    }
}
