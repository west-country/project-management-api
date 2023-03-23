<?php

namespace ProjectManagementApi\Tests\Entities;

use DateInterval;
use DateTime;
use ProjectManagementApi\Entities\Project;
use PHPUnit\Framework\TestCase;

require 'vendor/autoload.php';

class ProjectTest extends TestCase
{
    public function testSuccessConstructor_overdueTrue()
    {
        $deadline = new DateTime();
        $deadline->modify('-1 day');

        $testProject = new Project(1, 'name', 1, $deadline->format('Y-m-d'));
        $actualIsOverdue = $testProject->getIsOverdue();
        $expectedIsOverdu = true;
        $this->assertEquals($expectedIsOverdu, $actualIsOverdue);
    }

    public function testSuccessConstructor_overdueFalse()
    {
        $deadline = new DateTime();
        $deadline->modify('+1 day');

        $testProject = new Project(1, 'name', 1, $deadline->format('Y-m-d'));
        $actualIsOverdue = $testProject->getIsOverdue();
        $expectedIsOverdu = false;
        $this->assertEquals($expectedIsOverdu, $actualIsOverdue);
    }

    public function testSuccessConstructor_overdueNull()
    {
        $deadline = null;
        $testProject = new Project(1, 'name', 1, $deadline);
        $actualIsOverdue = $testProject->getIsOverdue();
        $expectedIsOverdu = null;
        $this->assertEquals($expectedIsOverdu, $actualIsOverdue);
    }

    public function testSuccessToAssociativeArray()
    {
        $deadline = '2012-12-21';
        $testProject = new Project(1, 'name', 1, $deadline);
        $expectedOutput = [
            'id' => '1',
            'name' => 'name',
            'client_id' => '1',
            'deadline' => '21/12/2012',
            'overdue' => true
        ];
        $actualOutput = $testProject->toAssociativeArray();
        $this->assertEquals($expectedOutput, $actualOutput);
    }
}
