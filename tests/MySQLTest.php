<?php

use \PHPUnit\Framework\TestCase;

class MySQLTest extends TestCase
{
    protected $db;

    public function setUp()
    {
        global $mysql_good_config;
        $this->db = new Mpopa\DataSource\MySQL($mysql_good_config);
    }

    public function testCreation()
    {
        global $mysql_wrong_config;
        $this->expectException("Mpopa\ExpException");
        new Mpopa\DataSource\MySQL($mysql_wrong_config);

        $this->assertNull($this->db);
    }

    public function testGetCustomers()
    {
        $this->assertInternalType("array", $this->db->getCustomers());
    }

    public function testGetProducts()
    {
        $this->assertInternalType("array", $this->db->getProducts());
    }

    public function testVerifyProduct()
    {
        // good product
        $this->assertInternalType("boolean", $this->db->verifyProduct([
            "product-id" => "B102",
            "quantity" => "5",
            "unit-price" => "4.99",
            "total" => "24.95",
        ]));

        // wrong product
        $this->assertInternalType("boolean", $this->db->verifyProduct([
            "product-id" => "B1023",
            "quantity" => "5",
            "unit-price" => "4.99",
            "total" => "24.95",
        ]));
    }

    public function testGetProductById()
    {
        $mysql_conn_object = $this->db->getProductById("A101");
        $this->assertInternalType("array", $mysql_conn_object);

        /**
         * Test integrity of response
         */
        $this->assertArrayHasKey('id', $mysql_conn_object);
        $this->assertArrayHasKey('description', $mysql_conn_object);
        $this->assertArrayHasKey('category', $mysql_conn_object);
        $this->assertArrayHasKey('price', $mysql_conn_object);

        $this->assertInternalType("string", $mysql_conn_object["id"]);
        $this->assertInternalType("string", $mysql_conn_object["description"]);
        $this->assertInternalType("integer", (int) $mysql_conn_object["category"]);
        $this->assertInternalType("float", (float) $mysql_conn_object["price"]);

        $this->assertNull($this->db->getProductById(-1));
    }

    public function testVerifyCustomer()
    {
        $mysql_conn_object = $this->db->verifyCustomer(1);
        $this->assertInternalType("boolean", $mysql_conn_object);
        $this->assertFalse($this->db->verifyCustomer(-1));
    }
}
