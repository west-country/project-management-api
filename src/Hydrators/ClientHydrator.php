<?php

namespace ProjectManagementApi\Hydrators;

use PDO;
use ProjectManagementApi\Entities\Client;

class ClientHydrator
{
    public static function getAllClients(PDO $pdo): array
    {
        $pdoStmt = $pdo->query('SELECT * FROM clients');
        $clients = $pdoStmt->fetchAll(PDO::FETCH_CLASS, Client::Class);

        return $clients;
    }
}