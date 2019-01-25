<?php

use \PHPUnit\Framework\TestCase;

class CustomersTest extends TestCase
{

    public function testFetchData()
    {
        global $mysql_good_config;
        global $mysql_wrong_config;
        global $json_good_config;
        global $json_wrong_config;

        $this->assertNull((new \Mpopa\Customers($json_good_config))->fetchData());
        $this->assertNull((new \Mpopa\Customers($mysql_good_config))->fetchData());

        $this->expectException("Mpopa\ExpException");
        $this->assertNull((new \Mpopa\Customers($json_wrong_config))->fetchData());
        $this->expectException("Mpopa\ExpException");
        $this->assertNull((new \Mpopa\Customers($mysql_wrong_config))->fetchData());
    }

    public function testGetCustomers()
    {
        global $mysql_good_config;
        global $mysql_wrong_config;
        global $json_good_config;
        global $json_wrong_config;

        $test_obj = new \Mpopa\Customers($json_good_config);
        $test_obj->fetchData();
        $this->assertInternalType("array", $test_obj->getCustomers());

        $test_obj = new \Mpopa\Customers($mysql_good_config);
        $test_obj->fetchData();
        $this->assertInternalType("array", $test_obj->getCustomers());

        $this->expectException("Mpopa\ExpException");
        $test_obj = new \Mpopa\Customers($json_wrong_config);
        $test_obj->fetchData();
        $this->assertNull($test_obj->getCustomers());

        $this->expectException("Mpopa\ExpException");
        $test_obj = new \Mpopa\Customers($mysql_wrong_config);
        $test_obj->fetchData();
        $this->assertNull($test_obj->getCustomers());
    }

    public function testVerifyCustomer()
    {
        global $mysql_good_config;
        global $mysql_wrong_config;
        global $json_good_config;
        global $json_wrong_config;

        $this->assertTrue((new \Mpopa\Customers($json_good_config))->verifyCustomer(1));
        $this->assertTrue((new \Mpopa\Customers($mysql_good_config))->verifyCustomer(1));

        $this->expectException("Mpopa\ExpException");
        $this->assertTrue((new \Mpopa\Customers($json_wrong_config))->verifyCustomer(1));

        $this->expectException("Mpopa\ExpException");
        $this->assertTrue((new \Mpopa\Customers($mysql_wrong_config))->verifyCustomer(1));
    }
}
