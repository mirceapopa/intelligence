<?php

use \PHPUnit\Framework\TestCase;

class CheapestFromCategoryTest extends TestCase
{
    private $order;
    private $cheapest_from_category_data;

    public function testCheapestFromCategoryCreation()
    {
        global $mysql_good_config;

        $this->cheapest_from_category_data = "{
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

        $this->order = new Mpopa\Order($this->cheapest_from_category_data, $mysql_good_config);
        $cheapest_from_category_object = \Mpopa\Discount\DiscountFactory::build($this->order);

        $this->assertInstanceOf("\Mpopa\Discount\CheapestFromCategory", $cheapest_from_category_object);
        $this->assertTrue($cheapest_from_category_object->isApplicable());
        $this->assertInternalType("boolean", $cheapest_from_category_object->isApplicable());

        /**
         * Test discount body
         */
        $discount_body = $cheapest_from_category_object->getDiscountBody();
        $this->assertInternalType("array", $discount_body);

        $this->assertArrayHasKey('status', $discount_body);
        $this->assertArrayHasKey('value', $discount_body);
        $this->assertArrayHasKey('percentage', $discount_body);
        $this->assertArrayHasKey('reason', $discount_body);
        $this->assertArrayHasKey('new_total', $discount_body);
        $this->assertArrayHasKey('error_message', $discount_body);

        $this->assertInternalType("string", $discount_body["status"]);
        $this->assertInternalType("float", $discount_body["value"]);
        $this->assertInternalType("float", $discount_body["percentage"]);
        $this->assertInternalType("string", $discount_body["reason"]);
        $this->assertInternalType("float", $discount_body["new_total"]);
        $this->assertInternalType("string", $discount_body["error_message"]);
    }
}
