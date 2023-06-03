<?php

namespace ProjectManagementApi\Tests\Entities;

use DateTimeImmutable;
use ProjectManagementApi\Exceptions\InvalidUserArrayDatatypeException;
use ProjectManagementApi\Entities\User;
use ProjectManagementApi\Entities\Project;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionObject;

require 'vendor/autoload.php';

class ProjectTest extends TestCase
{
    // protected static function getMethod($methodName) 
    // {
    //     $class = new ReflectionClass('ProjectManagementApi\Entities\Project');
    //     $method = $class->getMethod($methodName);
    //     $method->setAccessible(true);
    //     return $method;
    // }

    public static function callReflectionMethod(object $testObject, string $methodName, array $args = []): mixed
    {
        $class = new ReflectionClass('ProjectManagementApi\Entities\Project');
        $method = $class->getMethod($methodName);
        //$method->setAccessible(true);
        return $method->invokeArgs($testObject, $args);
    }

    public static function getProjectReflectionValue(string $key, object $testObject): mixed
    {
        $ReflectionProject = new ReflectionClass('ProjectManagementApi\Entities\Project');
        $reflectionProperty = $ReflectionProject->getProperty($key);
        return $reflectionProperty->getValue($testObject);
    }

    public static function setProjectReflectionValue(string $key, object $testObject, $value): void
    {
        $ReflectionProject = new ReflectionClass('ProjectManagementApi\Entities\Project');
        $reflectionProperty = $ReflectionProject->getProperty($key);
        $reflectionProperty->setValue($testObject, $value);
    }

    public function testSuccessSetOverdue_True()
    {
        $deadline = '1900-12-31';
        $testProject = new Project();
        self::setProjectReflectionValue('deadline', $testProject, $deadline);
        $testProject->__setIsOverdue();
        $actualIsOverdue = self::getProjectReflectionValue('isOverdue', $testProject);
        $expectedIsOverdue = true;
        $this->assertEquals($expectedIsOverdue, $actualIsOverdue);
    }

    public function testSuccessSetOverdue_False()
    {
        $deadline = '3000-12-31';
        $testProject = new Project();
        self::setProjectReflectionValue('deadline', $testProject, $deadline);
        $testProject->__setIsOverdue();
        $actualIsOverdue = self::getProjectReflectionValue('isOverdue', $testProject);
        $expectedIsOverdue = false;
        $this->assertEquals($expectedIsOverdue, $actualIsOverdue);
    }

    public function testSuccessSetOverdue_Null()
    {
        $deadline = null;
        $testProject = new Project();
        self::setProjectReflectionValue('deadline', $testProject, $deadline);
        $testProject->__setIsOverdue();
        $actualIsOverdue = self::getProjectReflectionValue('isOverdue', $testProject);
        $expectedIsOverdue = null;
        $this->assertEquals($expectedIsOverdue, $actualIsOverdue);
    }

    // public function testSuccessSetLocaleIsUSA_UK()
    // {

    // }

    public function testSuccessHandleLocale_US()
    {
        $deadline = new DateTimeImmutable('1900-12-31');
        $locale = 'US';
        $project = new Project();
        // $project->__setDeadline($deadline);
        self::setProjectReflectionValue('deadline', $project, $deadline);
        $project->handleLocale($locale);
        $actualDeadline = self::getProjectReflectionValue('deadline', $project);
        $expectedDeadline = '12/31/1900';
        $actualLocaleIsUSA = self::getProjectReflectionValue('localeIsUSA', $project);
        $expectedLocaleIsUSA = true;
        $this->assertEquals($actualDeadline, $expectedDeadline);
        $this->assertEquals($actualLocaleIsUSA, $expectedLocaleIsUSA);
    }

    public function testSuccessHandleLocale_UK()
    {
        $deadline = new DateTimeImmutable('1900-12-31');
        $locale = 'UK';
        $project = new Project();
        // $project->__setDeadline($deadline);
        self::setProjectReflectionValue('deadline', $project, $deadline);
        $project->handleLocale($locale);
        $actualDeadline = self::getProjectReflectionValue('deadline', $project);
        $expectedDeadline = '31/12/1900';
        $actualLocaleIsUSA = self::getProjectReflectionValue('localeIsUSA', $project);
        $expectedLocaleIsUSA = false;
        $this->assertEquals($actualDeadline, $expectedDeadline);
        $this->assertEquals($actualLocaleIsUSA, $expectedLocaleIsUSA);
    }

    public function testSuccessConvertDeadlineToDateTime_deadlineDate()
    {
        $deadlineString = '1989-02-06';
        $testProject = new Project();
        self::setProjectReflectionValue('deadline', $testProject, $deadlineString);
        self::callReflectionMethod($testProject, 'convertDeadlineToDateTime');
        $actualDeadline = self::getProjectReflectionValue('deadline', $testProject);
        $expectedDeadline = new DateTimeImmutable($deadlineString);
        $this->assertEquals($expectedDeadline, $actualDeadline);
    }

    // public function testSuccessConstructor_deadlineNull()
    // {
    //     $deadlineString = null;
    //     $testProject = new Project(1, 'name', 1, $deadlineString);
    //     $actualDeadline = $testProject->getDeadline();
    //     $expectedDeadline = null;
    //     $this->assertEquals($expectedDeadline, $actualDeadline);
    // }

    // public function testFailureConstructor_deadlineInvalid()
    // {
    //     $deadlineString = 'banana';
    //     $this->expectException(\Exception::class);
    //     $testProject = new Project(1, 'name', 1, $deadlineString);
    // }

    public function testFailureConstructor_IncorrectUserArrayDataType()
    {
        $bananaArray = ['banana' => 'banana', 'bananas' => 'bananas'];
        $deadline = '2012-12-21';
        $this->expectException(InvalidUserArrayDatatypeException::class);
        // $testProject = new Project(1, 'name', 1, $deadline, 'client name', 'http://dummyimage.com/200x200.png/ff4444/ffffff', $bananaArray);

    }



    // public function testSuccessToAssociativeArrayAllProperties()
    // {
    //     $testUsers = [];
    //     $testUserOne = $this->createMock(User::class);
    //     $testUserOne->method('toAssociativeArray')->willReturn(
    //         ['id' => '1', 'name' => 'name', 'avatar' => 'avatar', 'role' => 'role']
    //     );

    //     $testUserTwo = $this->createMock(User::class);
    //     $testUserTwo->method('toAssociativeArray')->willReturn(
    //         ['id' => '2', 'name' => 'name', 'avatar' => 'avatar', 'role' => 'role']
    //     );

    //     $testUserThree = $this->createMock(User::class);
    //     $testUserThree->method('toAssociativeArray')->willReturn(
    //         ['id' => '3', 'name' => 'name', 'avatar' => 'avatar', 'role' => 'role']
    //     );

}
