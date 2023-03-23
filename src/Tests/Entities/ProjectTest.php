<?php

namespace ProjectManagementApi\Tests\Entities;

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
        $expectedIsOverdue = true;
        $this->assertEquals($expectedIsOverdue, $actualIsOverdue);
    }

    public function testSuccessConstructor_overdueFalse()
    {
        $deadline = new DateTime();
        $deadline->modify('+1 day');

        $testProject = new Project(1, 'name', 1, $deadline->format('Y-m-d'));
        $actualIsOverdue = $testProject->getIsOverdue();
        $expectedIsOverdue = false;
        $this->assertEquals($expectedIsOverdue, $actualIsOverdue);
    }

    public function testSuccessConstructor_deadlineDate()
    {
        $deadlineString = '1989-02-06';
        $testProject = new Project(1,'name', 1, $deadlineString);
        $actualDeadline = $testProject->getDeadline();
        $expectedDeadline = new DateTime($deadlineString);
        $this->assertEquals($expectedDeadline, $actualDeadline);
    }

    public function testSuccessConstructor_deadlineNull()
    {
        $deadlineString = null;
        $testProject = new Project(1,'name', 1, $deadlineString);
        $actualDeadline = $testProject->getDeadline();
        $expectedDeadline = null;
        $this->assertEquals($expectedDeadline, $actualDeadline);
    }

    public function testFailureConstructor_deadlineInvalid()
    {   
        $deadlineString = 'banana';
        $this->expectException(\Exception::class);
        $testProject = new Project(1,'name', 1, $deadlineString);
            
    }

    public function testSuccessConstructor_overdueNull()
    {
        $deadline = null;
        $testProject = new Project(1, 'name', 1, $deadline);
        $actualIsOverdue = $testProject->getIsOverdue();
        $expectedIsOverdue = null;
        $this->assertEquals($expectedIsOverdue, $actualIsOverdue);
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
