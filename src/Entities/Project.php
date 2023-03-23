<?php

namespace ProjectManagementApi\Entities;

use DateTime;

use ProjectManagementApi\User;

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

    public function __construct(int $id, string $name, int $client_id, ?DateTime $deadline, ?string $client_name, ?string $client_logo, ?array $users)
    {
        $this->id = $id;
        $this->name = $name;
        $this->client_id = $client_id;
        $this->deadline = $deadline;
        $this->isOverdue = $this->calculateIsOverdue();
        $this->client_name = $client_name;
        $this->$client_logo = $client_logo;
        $this->users = $users;
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
        $usersArray = $this->users;

        foreach($usersArray as $user){
            //this method comes from User class
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
            'user' => $users
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
