<?php

namespace ProjectManagementApi\Hydrators;

use PDO;
use ProjectManagementApi\Entities\User;

class UserHydrator
{
    public static function getUsersByProjectId(PDO $pdo, int $id): array
    {
        $pdoStmt = $pdo->prepare(
            'SELECT users.id, `name`, avatar, `role` '
                . 'FROM users JOIN project_users '
                . 'ON users.id = user_id '
                . 'WHERE project_id = :project_id'
        );
        $pdoStmt->bindParam('project_id', $id, PDO::PARAM_INT);
        $pdoStmt->execute();
        $users = $pdoStmt->fetchAll(PDO::FETCH_CLASS, User::Class);
        return $users;
    }
}
