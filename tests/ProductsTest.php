<?php

use \PHPUnit\Framework\TestCase;

class ProductsTest extends TestCase
{

    public function testFetchData()
    {
        global $mysql_good_config;
        global $mysql_wrong_config;
        global $json_good_config;
        global $json_wrong_config;

        $this->assertNull((new \Mpopa\Products($json_good_config))->fetchData());
        $this->assertNull((new \Mpopa\Products($mysql_good_config))->fetchData());

        $this->expectException("Mpopa\ExpException");
        $this->assertNull((new \Mpopa\Products($json_wrong_config))->fetchData());
        $this->expectException("Mpopa\ExpException");
        $this->assertNull((new \Mpopa\Products($mysql_wrong_config))->fetchData());
    }

    public function testGetProducts()
    {
        global $mysql_good_config;
        global $mysql_wrong_config;
        global $json_good_config;
        global $json_wrong_config;

        $test_obj = new \Mpopa\Products($json_good_config);
        $test_obj->fetchData();
        $this->assertInternalType("array", $test_obj->getProducts());

        $test_obj = new \Mpopa\Products($mysql_good_config);
        $test_obj->fetchData();
        $this->assertInternalType("array", $test_obj->getProducts());

        $this->expectException("Mpopa\ExpException");
        $test_obj = new \Mpopa\Products($json_wrong_config);
        $test_obj->fetchData();
        $this->assertNull($test_obj->getProducts());

        $this->expectException("Mpopa\ExpException");
        $test_obj = new \Mpopa\Products($mysql_wrong_config);
        $test_obj->fetchData();
        $this->assertNull($test_obj->getProducts());
    }

    public function testVerifyProduct()
    {
        global $mysql_good_config;
        global $mysql_wrong_config;
        global $json_good_config;
        global $json_wrong_config;

        $this->assertTrue((new \Mpopa\Products($json_good_config))->verifyProduct([
            "product-id" => "B102",
            "quantity" => "5",
            "unit-price" => "4.99",
            "total" => "24.95",
        ]));
        $this->assertTrue((new \Mpopa\Products($mysql_good_config))->verifyProduct([
            "product-id" => "B102",
            "quantity" => "5",
            "unit-price" => "4.99",
            "total" => "24.95",
        ]));

        $this->expectException("Mpopa\ExpException");
        $this->assertTrue((new \Mpopa\Products($json_wrong_config))->verifyProduct([
            "product-id" => "B102",
            "quantity" => "5",
            "unit-price" => "4.99",
            "total" => "24.95",
        ]));

        $this->expectException("Mpopa\ExpException");
        $this->assertTrue((new \Mpopa\Products($mysql_wrong_config))->verifyProduct([
            "product-id" => "B102",
            "quantity" => "5",
            "unit-price" => "4.99",
            "total" => "24.95",
        ]));
    }

    public function testGetProductById()
    {
        global $mysql_good_config;
        global $mysql_wrong_config;
        global $json_good_config;
        global $json_wrong_config;

        $mysql_conn_object = (new \Mpopa\Products($mysql_good_config))->getProductById("A101");
        $json_conn_object = (new \Mpopa\Products($json_good_config))->getProductById("A101");

        $this->assertInternalType("array", $mysql_conn_object);
        $this->assertInternalType("array", $json_conn_object);

        /**
         * Test integrity of response
         */

        /**
         * MySQL connection
         */
        $this->assertArrayHasKey('id', $mysql_conn_object);
        $this->assertArrayHasKey('description', $mysql_conn_object);
        $this->assertArrayHasKey('category', $mysql_conn_object);
        $this->assertArrayHasKey('price', $mysql_conn_object);

        $this->assertInternalType("string", $mysql_conn_object["id"]);
        $this->assertInternalType("string", $mysql_conn_object["description"]);
        $this->assertInternalType("integer", (int) $mysql_conn_object["category"]);
        $this->assertInternalType("float", (float) $mysql_conn_object["price"]);

        /**
         * JSON connection
         */
        $this->assertArrayHasKey('id', $json_conn_object);
        $this->assertArrayHasKey('description', $json_conn_object);
        $this->assertArrayHasKey('category', $json_conn_object);
        $this->assertArrayHasKey('price', $json_conn_object);

        $this->assertInternalType("string", $json_conn_object["id"]);
        $this->assertInternalType("string", $json_conn_object["description"]);
        $this->assertInternalType("integer", (int) $json_conn_object["category"]);
        $this->assertInternalType("float", (float) $json_conn_object["price"]);

        $this->assertNull((new \Mpopa\Products($mysql_good_config))->getProductById(-1));
        $this->assertNull((new \Mpopa\Products($json_good_config))->getProductById(-1));

        $this->expectException("Mpopa\ExpException");
        $this->assertInternalType("array", (new \Mpopa\Products($json_wrong_config))->getProductById("A101"));

        $this->expectException("Mpopa\ExpException");
        $this->assertInternalType("array", (new \Mpopa\Products($mysql_wrong_config))->getProductById("A101"));
    }
}
