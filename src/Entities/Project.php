<?php

namespace ProjectManagementApi\Entities;

use JsonSerializable;
use DateTimeImmutable;

class Project implements JsonSerializable
{
    private int $id;
    private string $name;
    private int $client_id;
    private DateTimeImmutable|string|null $deadline = null;
    private ?bool $isOverdue = null;
    private ?string $client_name = null;
    private ?string $client_logo = null;
    private ?array $users = null;
    private bool $localeIsUSA = false;

    public function __setUsers(array $users): void
    {
        $this->users = $users;
    }

    public function __setIsOverdue(): void
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

    private function calculateIsOverdue(): bool
    {
        $currentDate = new DateTimeImmutable();
        $projectDeadline = $this->deadline;
        $isOverdue = $projectDeadline < $currentDate;
        return $isOverdue;
    }

    public function handleLocale(string $locale): void
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
                'deadline' => $this->deadline,
                'overdue' => $this->isOverdue
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
