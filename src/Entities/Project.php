<?php

namespace ProjectManagementApi\Entities;

use DateTime;
use ProjectManagementApi\Exceptions\InvalidUserArrayDatatypeException;
use ProjectManagementApi\Entities\User;

class Project
{
    private int $id;
    private string $name;
    private int $client_id;
    private ?DateTime $deadline;
    private ?bool $isOverdue;
    private ?string $client_name;
    private ?string $client_logo;
    private ?array $users;

    public function __construct(int $id, string $name, int $client_id, ?DateTime $deadline, ?string $client_name = null, ?string $client_logo = null, ?array $users = null)
    {
        if ($users != null) {
            $this->validateUsersArray($users);
        }
        $this->id = $id;
        $this->name = $name;
        $this->client_id = $client_id;
        $this->deadline = $deadline;
        $this->isOverdue = $this->calculateIsOverdue();
        $this->client_name = $client_name;
        $this->client_logo = $client_logo;
        $this->users = $users;
    }

    private function validateUsersArray(array $users)
    {
        foreach ($users as $user) {
            if (!($user instanceof User)) {
                throw new InvalidUserArrayDatatypeException("Invalid user array\n");
            }
        }
    }

    private function calculateIsOverdue(): ?bool
    {
        $currentDate = new DateTime();
        if ($this->deadline !== null) {
            return $this->deadline < $currentDate;
        } else {
            return null;
        }
    }

    // getIsOverdue() is purely for unit testing
    public function getIsOverdue(): ?bool
    {
        return $this->isOverdue;
    }

    public function toAssociativeArrayAllProperties(): array
    {
        $users = [];

        foreach ($this->users as $user) {
            $users[] = $user->toAssociativeArray();
        }

        return [
            'id' => strval($this->id),
            'name' => $this->name,
            'client_id' => strval($this->client_id),
            'deadline' => is_null($this->deadline) ? null : $this->deadline->format('d/m/Y'),
            'overdue' => $this->isOverdue,
            'client_name' => $this->client_name,
            'client_logo' => $this->client_logo,
            'users' => $users
        ];
    }

    public function toAssociativeArrayFewerProperties(): array
    {

        return [
            'id' => strval($this->id),
            'name' => $this->name,
            'client_id' => strval($this->client_id),
            'deadline' => is_null($this->deadline) ? null : $this->deadline->format('d/m/Y'),
            'overdue' => $this->isOverdue
        ];
    }
}
