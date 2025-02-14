<?php

namespace ProjectManagementApi\Entities;

use JsonSerializable;
use DateTimeImmutable;

class Task implements JsonSerializable
{
    private int $id;
    private int $project_id;
    private int $user_id;
    private string $name;
    private string $description;
    private ?int $estimate = null;
    private DateTimeImmutable|string|null $deadline = null;
    private ?bool $isOverdue = null;
    private ?int $estimate_hrs = null;
    private ?float $estimate_days = null;
    private bool $localeIsUSA;

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

    public function __setIsOverdue(): void
    {
        if (!is_null($this->deadline)) {
            $this->convertDeadlineToDateTime();
            $this->isOverdue = $this->calculateIsOverdue();
        }
    }

    private function calculateIsOverdue(): bool
    {
        $currentDate = new DateTimeImmutable();
        $projectDeadline = $this->deadline;
        $isOverdue = $projectDeadline < $currentDate;
        return $isOverdue;
    }

    public function __setLocaleIsUSA(string $locale): void
    {
        $this->localeIsUSA = ($locale == 'US') ?: false;
    }

    public function handleLocale(string $locale): void
    {
        $this->__setLocaleIsUSA($locale);
        $this->formatDeadline();
        if ($this->localeIsUSA == true && !is_null($this->estimate)) {
            $this->__setEstimate_Hrs()->__setEstimate_Days();
        }
    }

    private function __setEstimate_Hrs(): Task
    {
        $this->estimate_hrs = $this->estimate * 4;
        return $this;
    }

    private function __setEstimate_Days(): Task
    {
        $this->estimate_days = $this->estimate / 2;
        return $this;
    }

    public function jsonSerialize(): mixed
    {
        return array_filter([
            'id' => $this->id,
            'project_id' => $this->project_id,
            'user_id' => $this->user_id,
            'name' => $this->name,
            'description' => $this->description,
            'estimate' => $this->estimate,
            'deadline' => $this->deadline,
            'overdue' => $this->isOverdue,
            'estimate_hrs' => $this->estimate_hrs,
            'estimate_days' => $this->estimate_days,
        ], function ($projectProperty, $responseKey) {
            if ($this->localeIsUSA) {
                return $responseKey !== 'estimate';
            } else {
                return $responseKey !== 'estimate_hrs' && $responseKey !== 'estimate_days';
            }
        }, ARRAY_FILTER_USE_BOTH);
    }
}
