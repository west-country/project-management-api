<?php

namespace ProjectManagementApi\Tests\Entities;

use DateInterval;
use DateTime;
use ProjectManagementApi\Entities\Project;
use PHPUnit\Framework\TestCase;
require '../../../vendor/autoload.php';

class ProjectTest extends TestCase
{
    public function testSuccessConstructor_overdueTrue()
    {
        //creating a deadline that is 1 year before the current date
        $deadline = new DateTime();
        $dateInterval = new DateInterval('P1Y');
        $dateInterval->invert = 1;
        $deadline->add($dateInterval);
        
        $testProject = new Project(1, 'name', 1, $deadline);
        $actualOutput = $testProject->getIsOverdue();
        $expectedOutput = true;
        $this->assertEquals($expectedOutput, $actualOutput);
    }

    public function testSuccessConstructor_overdueFalse()
    {
        //creating a deadline that is 1 year after the current date
        $deadline = new DateTime();
        $dateInterval = new DateInterval('P1Y');
        $deadline->add($dateInterval);
        
        $testProject = new Project(1, 'name', 1, $deadline);
        $actualOutput = $testProject->getIsOverdue();
        $expectedOutput = false;
        $this->assertEquals($expectedOutput, $actualOutput);  
    }

    public function testSuccessConstructor_overdueNull()
    {
        $deadline = null;
        $testProject = new Project(1, 'name', 1, $deadline);
        $actualOutput = $testProject->getIsOverdue();
        $expectedOutput = null;
        $this->assertEquals($expectedOutput, $actualOutput); 
    }
    
    public function testSuccessToAssociativeArrayFewerProperties()
    {
        $deadline = DateTime::createFromFormat('d/m/Y', '21/12/2012');
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
}

