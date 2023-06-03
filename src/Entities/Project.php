<?php

namespace ProjectManagementApi\Entities;

use JsonSerializable;
use DateTimeImmutable;
use ProjectManagementApi\Exceptions\InvalidUserArrayDatatypeException;
use ProjectManagementApi\Entities\User;

class Project implements JsonSerializable
{
    private int $id; //
    private string $name; //
    private int $client_id; //
    private DateTimeImmutable|string|null $deadline; //
    private ?bool $isOverdue = null; //= null
    private ?string $client_name = null;
    private ?string $client_logo = null;
    private ?array $users = null;
    private bool $localeIsUSA = false;

    // public function __construct(int $id, string $name, int $client_id, DateTimeImmutable|string|null $deadline, ?bool $isOverdue, ?string $client_name, ?string $client_logo, ?array $users, bool $localeIsUSA = false)
    // {
    //     $this->id = $id;
    //     $this->name = $name;
    //     $this->client_id = $client_id;
    //     $this->deadline = $deadline;
    //     $this->isOverdue = $isOverdue;
    //     $this->client_name = $client_name;
    //     $this->client_logo = $client_logo;
    //     $this->users = $users;
    //     $this->localeIsUSA = $localeIsUSA;
    // }


    //
    // public function __setDeadline(DateTimeImmutable|string|null $deadline): void
    // {
    //     $this->deadline = $deadline;
    // }


    public function __setUsers(array $users): void
    {
        $this->users = $users;
    }

    public function __setIsOverdue(): void //TESTED
    {
        if (!is_null($this->deadline)) {
            $this->convertDeadlineToDateTime();
            $this->isOverdue = $this->calculateIsOverdue();
        }
    }

    public function __setLocaleIsUSA(string $locale): void
    {
        $this->localeIsUSA = ($locale == 'US') ?: false;
    }


    // getIsOverdue() is purely for unit testing
    // public function getIsOverdue(): ?bool
    // {
    //     return $this->isOverdue;
    // }

    // getDeadline() is purely for unit testing
    //convert
    // public function getDeadline(): ?DateTimeImmutable
    // {
    //     return $this->deadline;
    // }

    // public function getDeadline(): ?DateTimeImmutable
    // {
    //     return $this->deadline;
    // }

    private function convertDeadlineToDateTime(): void
    {
        $this->deadline = new DateTimeImmutable($this->deadline);
    }

    private function formatDeadline(): void
    {
        $this->deadline = $this->localeIsUSA ?
            $this->deadline?->format('m/d/Y') :
            $this->deadline?->format('d/m/Y');
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

    private function calculateIsOverdue(): bool
    {
        $currentDate = new DateTimeImmutable();
        $projectDeadline = $this->deadline;
        $isOverdue = $projectDeadline < $currentDate;
        return $isOverdue;
    }

    public function handleLocale(string $locale): void//TESTED
    {
        $this->__setLocaleIsUSA($locale);
        $this->formatDeadline();
    }

    public function jsonSerialize(): mixed
    {
        return array_filter(
            [
                'id' => $this->id,
                'name' => $this->name,
                'client_id' => $this->client_id,
                'client_name' => $this->client_name,
                'client_logo' => $this->client_logo,
                'users' => $this->users,
                'deadline' => $this->deadline ?? null,
                'overdue' => $this->isOverdue //?? null,
            ],
            function ($projectProperty, $responseKey) {
                return !is_null($projectProperty)
                    || $responseKey == 'deadline'
                    || $responseKey == 'overdue';
            },
            ARRAY_FILTER_USE_BOTH
        );
    }
}
