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
    private ?bool $isOverdue = null; //= null
    private ?int $estimate_hrs = null; //if locale=us// = null
    private ?float $estimate_days = null; // if locale=us// = null
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

    public function __setIsOverdue(): void //public
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
        // if($locale == 'US') {
        //     $this->localeIsUSA = true;
        // }
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
        //4hrs/point
        $this->estimate_hrs = $this->estimate * 4;
        return $this;
    }

    private function __setEstimate_Days(): Task
    {
        //8hrs/day
        //2points/day
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
            'estimate' => $this->estimate, // only if locale=uk
            'deadline' => $this->deadline,
            'overdue' => $this->isOverdue,
            'estimate_hrs' => $this->estimate_hrs, //if locale=us
            'estimate_days' => $this->estimate_days, // if locale=us
        ], function ($projectProperty, $responseKey) {
            if ($this->localeIsUSA) {
                // return !is_null($projectProperty) && $responseKey !== 'estimate';
                return $responseKey !== 'estimate';
            } else {
                //return !is_null($projectProperty);
                // return !is_null($projectProperty) && $responseKey !== 'estimate';
                return $responseKey !== 'estimate_hrs' && $responseKey !== 'estimate_days';
                //|| 'estimate_days');
            }
        }, ARRAY_FILTER_USE_BOTH);
    }
}
