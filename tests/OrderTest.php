<?php

use \PHPUnit\Framework\TestCase;

class OrderTest extends TestCase
{
    private $test_order;
    private $order_mysql_connection;
    private $order_json_connection;

    public function setUp()
    {
        /**
         * Cases for bad connections are tested in the datasources test classes
         */
        global $mysql_good_config;
        global $json_good_config;

        $this->test_order = "{
            \"id\": \"3\",
            \"customer-id\": \"3\",
            \"items\": [
              {
                \"product-id\": \"A101\",
                \"quantity\": \"2\",
                \"unit-price\": \"9.75\",
                \"total\": \"19.50\"
              },
              {
                \"product-id\": \"A102\",
                \"quantity\": \"1\",
                \"unit-price\": \"49.50\",
                \"total\": \"49.50\"
              }
            ],
            \"total\": \"69.00\"
          }
          ";

        $this->order_mysql_connection = new Mpopa\Order($this->test_order, $mysql_good_config);
        $this->order_json_connection = new Mpopa\Order($this->test_order, $json_good_config);
    }

    public function testOrderObjectCreation()
    {
        $this->assertInstanceOf("Mpopa\Order", $this->order_mysql_connection);
        $this->assertInstanceOf("Mpopa\Order", $this->order_json_connection);
    }

    public function testDiscountCalculation()
    {
        $mysql_conn_object = $this->order_mysql_connection->calculateDiscount();
        $json_conn_object = $this->order_mysql_connection->calculateDiscount();

        $this->assertInternalType("array", $mysql_conn_object);
        $this->assertInternalType("array", $json_conn_object);

        /**
         * Test integrity of response
         */

        /**
         * MySQL connection
         */
        $this->assertArrayHasKey('status', $mysql_conn_object);
        $this->assertArrayHasKey('value', $mysql_conn_object);
        $this->assertArrayHasKey('percentage', $mysql_conn_object);
        $this->assertArrayHasKey('reason', $mysql_conn_object);
        $this->assertArrayHasKey('new_total', $mysql_conn_object);
        $this->assertArrayHasKey('error_message', $mysql_conn_object);

        $this->assertInternalType("string", $mysql_conn_object["status"]);
        $this->assertInternalType("float", $mysql_conn_object["value"]);
        $this->assertInternalType("float", $mysql_conn_object["percentage"]);
        $this->assertInternalType("string", $mysql_conn_object["reason"]);
        $this->assertInternalType("float", $mysql_conn_object["new_total"]);
        $this->assertInternalType("string", $mysql_conn_object["error_message"]);

        /**
         * JSON connection
         */
        $this->assertArrayHasKey('status', $json_conn_object);
        $this->assertArrayHasKey('value', $json_conn_object);
        $this->assertArrayHasKey('percentage', $json_conn_object);
        $this->assertArrayHasKey('reason', $json_conn_object);
        $this->assertArrayHasKey('new_total', $json_conn_object);
        $this->assertArrayHasKey('error_message', $json_conn_object);

        $this->assertInternalType("string", $json_conn_object["status"]);
        $this->assertInternalType("float", $json_conn_object["value"]);
        $this->assertInternalType("float", $json_conn_object["percentage"]);
        $this->assertInternalType("string", $json_conn_object["reason"]);
        $this->assertInternalType("float", $json_conn_object["new_total"]);
        $this->assertInternalType("string", $json_conn_object["error_message"]);
    }

    public function testGetDiscount()
    {
        $mysql_conn_object = $this->order_mysql_connection->getOrderDiscount();
        $json_conn_object = $this->order_mysql_connection->getOrderDiscount();

        $this->assertInternalType("array", $mysql_conn_object);
        $this->assertInternalType("array", $json_conn_object);

        /**
         * Test integrity of response
         */

        /**
         * MySQL connection
         */
        $this->assertArrayHasKey('status', $mysql_conn_object);
        $this->assertArrayHasKey('value', $mysql_conn_object);
        $this->assertArrayHasKey('percentage', $mysql_conn_object);
        $this->assertArrayHasKey('reason', $mysql_conn_object);
        $this->assertArrayHasKey('new_total', $mysql_conn_object);
        $this->assertArrayHasKey('error_message', $mysql_conn_object);

        $this->assertInternalType("string", $mysql_conn_object["status"]);
        $this->assertInternalType("float", $mysql_conn_object["value"]);
        $this->assertInternalType("float", $mysql_conn_object["percentage"]);
        $this->assertInternalType("string", $mysql_conn_object["reason"]);
        $this->assertInternalType("float", $mysql_conn_object["new_total"]);
        $this->assertInternalType("string", $mysql_conn_object["error_message"]);

        /**
         * JSON connection
         */
        $this->assertArrayHasKey('status', $json_conn_object);
        $this->assertArrayHasKey('value', $json_conn_object);
        $this->assertArrayHasKey('percentage', $json_conn_object);
        $this->assertArrayHasKey('reason', $json_conn_object);
        $this->assertArrayHasKey('new_total', $json_conn_object);
        $this->assertArrayHasKey('error_message', $json_conn_object);

        $this->assertInternalType("string", $json_conn_object["status"]);
        $this->assertInternalType("float", $json_conn_object["value"]);
        $this->assertInternalType("float", $json_conn_object["percentage"]);
        $this->assertInternalType("string", $json_conn_object["reason"]);
        $this->assertInternalType("float", $json_conn_object["new_total"]);
        $this->assertInternalType("string", $json_conn_object["error_message"]);
    }

    public function testGetProducts()
    {
        $mysql_conn_object = $this->order_mysql_connection->getProducts();
        $json_conn_object = $this->order_mysql_connection->getProducts();

        $this->assertInstanceOf("\Mpopa\Products", $mysql_conn_object);
        $this->assertInstanceOf("\Mpopa\Products", $json_conn_object);
    }

    public function testGetProductById()
    {
        $mysql_conn_object = $this->order_mysql_connection->getProductById("A101");
        $json_conn_object = $this->order_mysql_connection->getProductById("A101");

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

        $mysql_conn_object = $this->order_mysql_connection->getProductById(-1);
        $json_conn_object = $this->order_mysql_connection->getProductById(-1);

        $this->assertNull($mysql_conn_object);
        $this->assertNull($json_conn_object);
    }

    public function testGetOrderItems()
    {
        $mysql_conn_object = $this->order_mysql_connection->getOrderItems();
        $json_conn_object = $this->order_mysql_connection->getOrderItems();

        $this->assertInternalType("array", $mysql_conn_object);
        $this->assertInternalType("array", $json_conn_object);
    }

    public function testVerifyOrderIntegrity()
    {
        $mysql_conn_object = $this->order_mysql_connection->verifyOrderIntegrity(json_decode($this->test_order, true));
        $json_conn_object = $this->order_mysql_connection->verifyOrderIntegrity(json_decode($this->test_order, true));

        $this->assertInternalType("boolean", $mysql_conn_object);
        $this->assertInternalType("boolean", $json_conn_object);

        $this->expectException("\Mpopa\ExpException");
        $mysql_conn_object = $this->order_mysql_connection->verifyOrderIntegrity([]);

        $this->expectException("\Mpopa\ExpException");
        $json_conn_object = $this->order_mysql_connection->verifyOrderIntegrity([]);
    }

    public function testVerifyOrderData()
    {
        $mysql_conn_object = $this->order_mysql_connection->verifyOrderData();
        $json_conn_object = $this->order_mysql_connection->verifyOrderData();

        $this->assertInternalType("boolean", $mysql_conn_object);
        $this->assertInternalType("boolean", $json_conn_object);
    }
}
