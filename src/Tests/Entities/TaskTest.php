<?php

namespace ProjectManagementApi\Tests\Entities;

use DateTimeImmutable;
use ProjectManagementApi\Entities\Task;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

require 'vendor/autoload.php';

class TaskTest extends TestCase
{
    public static function callReflectionMethod(object $testObject, string $methodName, array $args = []): mixed
    {
        $class = new ReflectionClass('ProjectManagementApi\Entities\Task');
        $method = $class->getMethod($methodName);
        //$method->setAccessible(true);
        return $method->invokeArgs($testObject, $args);
    }

    public static function getTaskReflectionValue(string $key, object $testObject): mixed
    {
        $ReflectionProject = new ReflectionClass('ProjectManagementApi\Entities\Task');
        $reflectionProperty = $ReflectionProject->getProperty($key);
        return $reflectionProperty->getValue($testObject);
    }

    public static function setTaskReflectionValue(string $key, object $testObject, $value): void
    {
        $ReflectionProject = new ReflectionClass('ProjectManagementApi\Entities\Task');
        $reflectionProperty = $ReflectionProject->getProperty($key);
        $reflectionProperty->setValue($testObject, $value);
    }

    public function testSuccessSetOverdue_True()
    {
        $deadline = '1900-12-31';
        $testTask = new Task();
        self::setTaskReflectionValue('deadline', $testTask, $deadline);
        $testTask->__setIsOverdue();
        $actualIsOverdue = self::getTaskReflectionValue('isOverdue', $testTask);
        $expectedIsOverdue = true;
        $this->assertEquals($expectedIsOverdue, $actualIsOverdue);
    }

    public function testSuccessSetOverdue_False()
    {
        $deadline = '3000-12-31';
        $testTask = new Task();
        self::setTaskReflectionValue('deadline', $testTask, $deadline);
        $testTask->__setIsOverdue();
        $actualIsOverdue = self::getTaskReflectionValue('isOverdue', $testTask);
        $expectedIsOverdue = false;
        $this->assertEquals($expectedIsOverdue, $actualIsOverdue);
    }

    public function testSuccessSetOverdue_Null()
    {
        $deadline = null;
        $testTask = new Task();
        self::setTaskReflectionValue('deadline', $testTask, $deadline);
        $testTask->__setIsOverdue();
        $actualIsOverdue = self::getTaskReflectionValue('isOverdue', $testTask);
        $expectedIsOverdue = null;
        $this->assertEquals($expectedIsOverdue, $actualIsOverdue);
    }

    public function testSuccessHandleLocale_US()
    {
        $deadline = new DateTimeImmutable('1900-12-31');
        $locale = 'US';
        $task = new Task();
        self::setTaskReflectionValue('deadline', $task, $deadline);
        $task->handleLocale($locale);
        $actualDeadline = self::getTaskReflectionValue('deadline', $task);
        $expectedDeadline = '12/31/1900';
        $actualLocaleIsUSA = self::getTaskReflectionValue('localeIsUSA', $task);
        $expectedLocaleIsUSA = true;
        $this->assertEquals($actualDeadline, $expectedDeadline);
        $this->assertEquals($actualLocaleIsUSA, $expectedLocaleIsUSA);
    }

    public function testSuccessHandleLocale_UK()
    {
        $deadline = new DateTimeImmutable('1900-12-31');
        $locale = 'UK';
        $task = new Task();
        self::setTaskReflectionValue('deadline', $task, $deadline);
        $task->handleLocale($locale);
        $actualDeadline = self::getTaskReflectionValue('deadline', $task);
        $expectedDeadline = '31/12/1900';
        $actualLocaleIsUSA = self::getTaskReflectionValue('localeIsUSA', $task);
        $expectedLocaleIsUSA = false;
        $this->assertEquals($actualDeadline, $expectedDeadline);
        $this->assertEquals($actualLocaleIsUSA, $expectedLocaleIsUSA);
    }

    public function testSuccessConvertDeadlineToDateTime_deadlineDate()
    {
        $deadlineString = '1989-02-06';
        $testTask = new Task();
        self::setTaskReflectionValue('deadline', $testTask, $deadlineString);
        self::callReflectionMethod($testTask, 'convertDeadlineToDateTime');
        $actualDeadline = self::getTaskReflectionValue('deadline', $testTask);
        $expectedDeadline = new DateTimeImmutable($deadlineString);
        $this->assertEquals($expectedDeadline, $actualDeadline);
    }

    public function testSuccessConvertDeadlineToDateTime_deadlineInvalid()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Failed to parse time string (foo) at position 0 (f): The timezone could not be found in the database");
        $deadlineString = 'foo';
        $testTask = new Task();
        self::setTaskReflectionValue('deadline', $testTask, $deadlineString);
        self::callReflectionMethod($testTask, 'convertDeadlineToDateTime');
    }
}
