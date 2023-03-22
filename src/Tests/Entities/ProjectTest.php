<?php

namespace ProjectManagementApi\Tests\Entities;

use DateInterval;
use DateTime;
use ProjectManagementApi\Entities\Project;
use PHPUnit\Framework\TestCase;
require '../../../vendor/autoload.php';

class ProjectTest extends TestCase
{
    public function testSuccessConstructor_OverdueTrue()
    {
        $currentDate = new DateTime();
        $deadline = new DateTime();
        $dateInterval = new DateInterval('P1Y');
        $dateInterval->invert=1;
        $deadline->add($dateInterval);
        $testProject = new Project(1, 'name', 1, $deadline);
        $actualOutput = $testProject->getIsOverdue();
        $expectedOutput = true;
        $this->assertEquals($expectedOutput, $actualOutput);
    }
}

