<?php

use \PHPUnit\Framework\TestCase;

class HelperTest extends TestCase
{

    public function testIsIntegerAndPositive()
    {
        $this->assertInternalType("boolean", \Mpopa\Helper::isIntegerAndPositive(1));
        $this->assertTrue(\Mpopa\Helper::isIntegerAndPositive(1));
        $this->assertFalse(\Mpopa\Helper::isIntegerAndPositive(-1));
    }

    public function testIsFloatAndPositive()
    {
        $this->assertInternalType("boolean", \Mpopa\Helper::isFloatAndPositive(1.1));
        $this->assertTrue(\Mpopa\Helper::isFloatAndPositive(1.1));
        $this->assertFalse(\Mpopa\Helper::isFloatAndPositive(-1.1));
    }

    public function testIsFloat()
    {
        $this->assertInternalType("boolean", \Mpopa\Helper::isFloat(1.1));
        $this->assertTrue(\Mpopa\Helper::isFloat(1.1));
        $this->assertFalse(\Mpopa\Helper::isFloat("x"));
    }

    public function testIsJSON()
    {
        $test_json = json_encode(["x" => "y"]);
        $this->assertInternalType("boolean", \Mpopa\Helper::isJSON($test_json));
        $this->assertTrue(\Mpopa\Helper::isJSON($test_json));

        $this->expectException("\Mpopa\ExpException");
        \Mpopa\Helper::isJSON("x");
    }

    public function testFileExists()
    {
        $test_file = "https://raw.githubusercontent.com/teamleadercrm/coding-test/master/example-orders/order3.json";

        $this->assertInternalType("boolean", \Mpopa\Helper::fileExists($test_file));
        $this->assertTrue(\Mpopa\Helper::fileExists($test_file));
        $this->expectException("\Mpopa\ExpException");
        \Mpopa\Helper::fileExists("FileThatNotExists.txt");
    }

    public function testValidateArrayKeys()
    {
        $keys = ["x", "y"];
        $ok_array = ["x" => 1, "y" => 2];
        $nok_array = ["a" => 1, "b" => 2];
        $this->assertInternalType("boolean", \Mpopa\Helper::validateArrayKeys($keys, $ok_array));
        $this->assertTrue(\Mpopa\Helper::validateArrayKeys($keys, $ok_array));
        $this->assertFalse(\Mpopa\Helper::validateArrayKeys($keys, $nok_array));
    }

    public function testGetRequestOrder()
    {
        $test_json = json_encode(["x" => "y"]);
        $test_file = "https://raw.githubusercontent.com/teamleadercrm/coding-test/master/example-orders/order3.json";

        $this->assertEquals(\Mpopa\Helper::getRequestOrder([], [], []), '');
        $this->assertEquals(\Mpopa\Helper::getRequestOrder(["order" => ""], [], []), '');
        $this->assertEquals(\Mpopa\Helper::getRequestOrder([], ["FileThatNotExists.json"], []), '');
        $this->assertNotEquals(\Mpopa\Helper::getRequestOrder(["order" => $test_file], [], []), '');
    }
}
