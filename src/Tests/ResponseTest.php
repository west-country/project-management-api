<?php

namespace ProjectManagementApi\Tests;

require '../../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use ProjectManagementApi\Response;

class ResponseTest extends TestCase
{
    public function testSuccessJsonSerialize()
    {
        $expectedOutput = ['message' => 'Successfully retrieved projects', 'data' => [['id' => 17, 'name' => 'Overhold', 'client_id' => 7, 'deadline' => '30/06/2022', 'overdue' => true], ['id' => 18, 'name' => 'Wrapsafe', 'client_id' => 18, 'deadline' => '28/03/2024', 'overdue' => false]]];
        
        $message = 'Successfully retrieved projects';

        $data = [['id' => 17, 'name' => 'Overhold', 'client_id' => 7, 'deadline' => '30/06/2022', 'overdue' => true], ['id' => 18, 'name' => 'Wrapsafe', 'client_id' => 18, 'deadline' => '28/03/2024', 'overdue' => false]];

        $response = new Response($message, $data);
        
        $actualOutput = $response->jsonSerialize();
        $this->assertEquals($expectedOutput, $actualOutput);
    }    
}



