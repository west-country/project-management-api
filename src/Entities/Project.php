<?php

namespace ProjectManagementApi\Entities;
use DateTime;

class Project
{
    private int $id;
    private string $name;
    private int $client_id;
    private ?string $deadline;
    private ?bool $isOverdue;

    public function __construct(int $id, string $name, int $client_id, ?string $deadline)
    {
        $this->id = $id;
        $this->name = $name;
        $this->client_id = $client_id;
        $this->deadline = new DateTime($deadline);
        $this->isOverdue = $this->calculateIsOverdue();
    }

    private function calculateIsOverdue(): bool|null
    {
        $currentDate = new DateTime();
        if($this->deadline !== null) {
            return $this->deadline < $currentDate;
        } else {
            return null;
        }
    }

    // getIsOverdue() is purely for unit testing
    public function getIsOverdue(): bool|null
    {
        return $this->isOverdue;
    }

    public function toAssociativeArrayFewerProperties(): array
    {
        return ['id' => $this->id, 'name' => $this->name, 'client_id' => $this->client_id, 'deadline' => $this->deadline, 'overdue' => $this->isOverdue];
    }
}

