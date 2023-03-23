<?php

namespace ProjectManagementApi\Tests\Entities;

use DateTime;
use ProjectManagementApi\Exceptions\InvalidUserArrayDatatypeException;
use ProjectManagementApi\Entities\User;
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

    public function testSuccessConstructor_overdueNull()
    {
        $deadline = null;
        $testProject = new Project(1, 'name', 1, $deadline);
        $actualIsOverdue = $testProject->getIsOverdue();
        $expectedIsOverdue = null;
        $this->assertEquals($expectedIsOverdue, $actualIsOverdue);
    }

    public function testSuccessConstructor_deadlineDate()
    {
        $deadlineString = '1989-02-06';
        $testProject = new Project(1, 'name', 1, $deadlineString);
        $actualDeadline = $testProject->getDeadline();
        $expectedDeadline = new DateTime($deadlineString);
        $this->assertEquals($expectedDeadline, $actualDeadline);
    }

    public function testSuccessConstructor_deadlineNull()
    {
        $deadlineString = null;
        $testProject = new Project(1, 'name', 1, $deadlineString);
        $actualDeadline = $testProject->getDeadline();
        $expectedDeadline = null;
        $this->assertEquals($expectedDeadline, $actualDeadline);
    }

    public function testFailureConstructor_deadlineInvalid()
    {
        $deadlineString = 'banana';
        $this->expectException(\Exception::class);
        $testProject = new Project(1, 'name', 1, $deadlineString);
    }

    public function testFailureConstructor_IncorrectUserArrayDataType()
    {
        $bananaArray = ['banana' => 'banana', 'bananas' => 'bananas'];
        $deadline = '2012-12-21';
        $this->expectException(InvalidUserArrayDatatypeException::class);
        $testProject = new Project(1, 'name', 1, $deadline, 'client name', 'http://dummyimage.com/200x200.png/ff4444/ffffff', $bananaArray);
    }

    public function testSuccessToAssociativeArrayFewerProperties()
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
        $actualOutput = $testProject->toAssociativeArrayFewerProperties();
        $this->assertEquals($expectedOutput, $actualOutput);
    }

    public function testSuccessToAssociativeArrayAllProperties()
    {
        $testUsers = [];
        $testUserOne = $this->createMock(User::class);
        $testUserOne->method('toAssociativeArray')->willReturn(
            ['id' => 1, 'name' => 'name', 'avatar' => 'avatar', 'role' => 'role']
        );

        $testUserTwo = $this->createMock(User::class);
        $testUserTwo->method('toAssociativeArray')->willReturn(
            ['id' => 2, 'name' => 'name', 'avatar' => 'avatar', 'role' => 'role']
        );

        $testUserThree = $this->createMock(User::class);
        $testUserThree->method('toAssociativeArray')->willReturn(
            ['id' => 3, 'name' => 'name', 'avatar' => 'avatar', 'role' => 'role']
        );

        array_push($testUsers, $testUserOne, $testUserTwo, $testUserThree);
        $deadline = '2012-12-21';
        $testProject = new Project(1, 'name', 1, $deadline, 'client name', 'http://dummyimage.com/200x200.png/ff4444/ffffff', $testUsers);
        $expectedOutput = [
            'id' => '1',
            'name' => 'name',
            'client_id' => '1',
            'deadline' => '21/12/2012',
            'overdue' => true,
            'client_name' => 'client name',
            'client_logo' => 'http://dummyimage.com/200x200.png/ff4444/ffffff',
            'users' => [
                ['id' => '1', 'name' => 'name', 'avatar' => 'avatar', 'role' => 'role'],
                ['id' => '2', 'name' => 'name', 'avatar' => 'avatar', 'role' => 'role'],
                ['id' => '3', 'name' => 'name', 'avatar' => 'avatar', 'role' => 'role']
            ]
        ];
        $actualOutput = $testProject->toAssociativeArrayAllProperties();
        $this->assertEquals($expectedOutput, $actualOutput);
    }

}
