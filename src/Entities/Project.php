<?php

namespace ProjectManagementApi\Entities;

use JsonSerializable;
use DateTimeImmutable;
use ProjectManagementApi\Exceptions\InvalidUserArrayDatatypeException;
use ProjectManagementApi\Entities\User;

class Project implements JsonSerializable
{
    private int $id;
    private string $name;
    private int $client_id;
    private DateTimeImmutable|string|null $deadline;
    private ?bool $isOverdue;
    private ?string $client_name = null;
    private ?string $client_logo = null;
    private ?array $users = null;

    // public function __construct(int $id, string $name, int $client_id, ?string $deadline, ?string $client_name = null, ?string $client_logo = null, ?array $users = null)

    // public function __construct(?string $deadline) {
    //     $this->deadline = $deadline ? "none specified" : new DateTime($deadline) ;
    // }

    // public function __getDeadline() {
    //      return $this->deadline;
    // }

    // public function convertDeadline(bool $localeIsUSA = false)
    // {
    //     if ($this->deadline) {
    //         $convertedDeadline = new DateTimeImmutable($this->deadline);
    //         $convertedDeadline = $localeIsUSA ? $convertedDeadline->format('m/d/Y') : $convertedDeadline->format('d/m/Y');
    //         $this->deadline = $convertedDeadline;
    //     }
    // }

    public function convertDeadlineToDateTime()
    {
        if (!is_null($this->deadline)) {
            $this->deadline = new DateTimeImmutable($this->deadline);
        }
    }

    public function formatDeadline(bool $localeIsUSA = false)
    {
        $convertedDeadline = $this->deadline;
        $convertedDeadline = $localeIsUSA ? $convertedDeadline?->format('m/d/Y') : $convertedDeadline?->format('d/m/Y');
        $this->deadline = $convertedDeadline;
    }

    public function __setUsers($users)
    {
        $this->users = $users;
    }

    // private function validateUsersArray(array $users)
    // {
    //     foreach ($users as $user) {
    //         if (!($user instanceof User)) {
    //             throw new InvalidUserArrayDatatypeException('Incorrect datatype in $users argument of Project constructor.
    //              Expected array of User objects. We found: ' . gettype($user) . '\n');
    //         }
    //     }
    // }

    // $project->convertDeadlineToDatetime();
    //         $project->__setIsOverdue();
    //         $project->formatDeadline($localeIsUSA);

    public function __setIsOverdue()
    {
        if (!is_null($this->deadline)) {
            $this->isOverdue = $this->calculateIsOverdue();
        }
    }

    private function calculateIsOverdue(): ?bool
    {
        if (!is_null($this->deadline)) {
            $currentDate = new DateTimeImmutable();
            $projectDeadline = $this->deadline;
            $isOverdue = $projectDeadline < $currentDate;
            return $isOverdue;
        }
    }

    // getIsOverdue() is purely for unit testing
    public function getIsOverdue(): ?bool
    {
        return $this->isOverdue;
    }

    // getDeadline() is purely for unit testing
    public function getDeadline(): ?DateTime
    {
        return $this->deadline;
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

    public function jsonSerialize(): mixed
    {
        return array_filter(
            [
                'id' => $this->id,
                'name' => $this->name,
                'client_id' => $this->client_id,
                // isset($this->client_name) ?: 'client_name' => $this->client_name,
                'client_name' => $this->client_name,
                'client_logo' => $this->client_logo,
                'users' => $this->users,
                // 'deadline' => is_null($this->deadline) ? null : $this->deadline->format('d/m/Y'),
                'deadline' => $this->deadline ?? "none specified",
                'isOverdue' => $this->isOverdue ?? "n/a",
            ],
            function ($projectProperty) {
                return !is_null($projectProperty);
            }
        );
    }
}
