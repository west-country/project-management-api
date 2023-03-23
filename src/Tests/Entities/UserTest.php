<?php

namespace ProjectManagementApi\Tests\Entities;

use ProjectManagementApi\Entities\User;
use PHPUnit\Framework\TestCase;

require 'vendor/autoload.php';

class UserTest extends TestCase
{
    public function testSuccessToAssociativeArray()
    {
        $testUser = new User(1, 'Adam', 'https://www.somecoolimage.com/cooladam.jpg', 'absolute bloody legend');
        $expectedOutput = [
            'id' => '1',
            'name' => 'Adam',
            'avatar' => 'https://www.somecoolimage.com/cooladam.jpg',
            'role' => 'absolute bloody legend',
        ];
        $actualOutput = $testUser->toAssociativeArray();
        $this->assertEquals($expectedOutput, $actualOutput);
    }
}