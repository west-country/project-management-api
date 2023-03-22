<?php

namespace ProjectManagementApi\Hydrators\ProjectHydratorDemo;

use DateTime;

class Project
{
    private int $id;
    private string $name;
    private int $client_id;
    private ?DateTime $deadline;

    public function __construct($id, $name, $client_id, $deadline)
    {
        $this->id = $id;
        $this->name = $name;
        $this->client_id = $client_id;
        $this->deadline = $deadline;
    }

    public function toAssociativeArrayFewerProperties(): array
    {
        return [
            'this' => 'is',
            'an' => 'associative',
            'array' => 'now'
        ];
    }
}
