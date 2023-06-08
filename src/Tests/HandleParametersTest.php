<?php

namespace ProjectManagementApi\Tests;

require_once 'src/handleParameters.php';

use PHPUnit\Framework\TestCase;

class HandleParametersTest extends TestCase
{
    public function testSuccessHandleLocaleParameter_USlower()
    {
        $expectedOutput = "US";
        $actualOutput = handleLocaleParameter("us");
        $this->assertEquals($expectedOutput, $actualOutput);
    }

    public function testSuccessHandleLocaleParameter_UKlower()
    {
        $expectedOutput = "UK";
        $actualOutput = handleLocaleParameter("uk");
        $this->assertEquals($expectedOutput, $actualOutput);
    }

    public function testSuccessHandleLocaleParameter_Invalid()
    {
        $this->expectException(\ProjectManagementApi\Exceptions\InvalidParameterException::class);
        handleLocaleParameter("foo");
    }

    public function testHandleRequiredNumericalParameter_Valid()
    {
        $_GET = array('foo' => 1234);
        $expectedOutput = 1234;
        $actualOutput = handleRequiredNumericalParameter("foo", "error message");
        $this->assertEquals($expectedOutput, $actualOutput);
    }

    public function testHandleRequiredNumericalParameter_String()
    {
        $this->expectException(\ProjectManagementApi\Exceptions\InvalidParameterException::class);
        $_GET = array('foo' => 'bar');
        handleRequiredNumericalParameter("foo", "error message");
    }

    public function testHandleRequiredNumericalParameter_NotSet()
    {
        $this->expectException(\ProjectManagementApi\Exceptions\InvalidParameterException::class);
        $_GET = array('foo' => 1234);
        handleRequiredNumericalParameter("baz", "error message");
    }
}
