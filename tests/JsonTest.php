<?php

use \PHPUnit\Framework\TestCase;

class JsonTest extends TestCase
{
    protected $db;
    protected $wrong_db;

    public function setUp()
    {
        global $json_good_config;
        global $json_wrong_config;

        $this->db = new Mpopa\DataSource\Json($json_good_config);
        $this->wrong_db = new Mpopa\DataSource\Json($json_wrong_config);
    }

    public function testCreation()
    {
        $this->assertNotNull($this->db);
    }

    public function testGetCustomers()
    {
        $this->assertInternalType("array", $this->db->getCustomers());
        $this->expectException("\Mpopa\ExpException");
        $this->wrong_db->getCustomers();
    }

    public function testGetProducts()
    {
        $this->assertInternalType("array", $this->db->getProducts());
        $this->expectException("\Mpopa\ExpException");
        $this->wrong_db->getProducts();
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
        $this->db->getProducts();

        $json_conn_object = $this->db->getProductById("A101");
        $this->assertInternalType("array", $json_conn_object);

        /**
         * Test integrity of response
         */
        $this->assertArrayHasKey('id', $json_conn_object);
        $this->assertArrayHasKey('description', $json_conn_object);
        $this->assertArrayHasKey('category', $json_conn_object);
        $this->assertArrayHasKey('price', $json_conn_object);

        $this->assertInternalType("string", $json_conn_object["id"]);
        $this->assertInternalType("string", $json_conn_object["description"]);
        $this->assertInternalType("integer", (int) $json_conn_object["category"]);
        $this->assertInternalType("float", (float) $json_conn_object["price"]);

        $this->assertNull($this->db->getProductById(-1));
    }

    public function testVerifyCustomer()
    {
        $this->assertInternalType("boolean", $this->db->verifyCustomer(1));
        $this->assertFalse($this->db->verifyCustomer(-1));
    }
}
