<?php

namespace ProjectManagementApi\Tests\Entities;

use DateTimeImmutable;
use ProjectManagementApi\Exceptions\InvalidUserArrayDatatypeException;
use ProjectManagementApi\Entities\User;
use ProjectManagementApi\Entities\Task;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionObject;

require 'vendor/autoload.php';

class TaskTest extends TestCase
{
    public static function callReflectionMethod(object $testObject, string $methodName, array $args = []): mixed {
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

}