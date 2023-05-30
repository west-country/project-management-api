<?php

namespace ProjectManagementApi\Hydrators;

use PDO;
use ProjectManagementApi\Entities\Client;
//use ProjectManagementApi\Exceptions\InvalidProjectIdException;

use ProjectManagementApi\Response;

class ClientHydrator
{
    public static function getAllClients(PDO $pdo): array
    {
        $pdoStmt = $pdo->query('SELECT * FROM ProjectManagement.clients');
        $clients = $pdoStmt->fetchAll(PDO::FETCH_CLASS, Client::Class);

        return $clients;
    }
}