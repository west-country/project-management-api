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
    private ?int $estimate; // only if locale=uk
    private DateTimeImmutable|string|null $deadline;
    private ?bool $isOverdue;
    private ?int $estimate_hrs; //if locale=us
    private ?int $estimate_days; // if locale=us

    private function convertDeadlineToDateTime()//public
    {
        if (!is_null($this->deadline)) {
            $this->deadline = new DateTimeImmutable($this->deadline);
        }
    }

    private function formatDeadline(bool $localeIsUSA = false)//public
    {
        $convertedDeadline = $this->deadline;
        $convertedDeadline = $localeIsUSA ? $convertedDeadline?->format('m/d/Y') : $convertedDeadline?->format('d/m/Y');
        $this->deadline = $convertedDeadline;
    }

    private function __setIsOverdue()//public
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

    public function jsonSerialize(): mixed
    {
        // private int $id;
        // private int $project_id;
        // private int $user_id;
        // private string $name;
        // private string $description;
        // private ?int $estimate; // only if locale=uk
        // private DateTimeImmutable|string|null $deadline;
        // private ?bool $isOverdue;
        // private ?int $estimate_hrs; //if locale=us
        // private ?int $estimate_days; // if locale=us
    }
}

