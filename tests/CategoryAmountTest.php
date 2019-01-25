<?php

use \PHPUnit\Framework\TestCase;

class CategoryAmountTest extends TestCase
{
    private $order;
    private $category_amount_discount_data;

    public function testCategoryAmountCreation()
    {
        global $mysql_good_config;        
        
        $this->category_amount_discount_data = "{
            \"id\": \"2\",
            \"customer-id\": \"2\",
            \"items\": [
              {
                \"product-id\": \"B102\",
                \"quantity\": \"5\",
                \"unit-price\": \"4.99\",
                \"total\": \"24.95\"
              }
            ],
            \"total\": \"24.95\"
          }
          ";

        $this->order = new Mpopa\Order($this->category_amount_discount_data, $mysql_good_config);
        $category_amount_object = \Mpopa\Discount\DiscountFactory::build($this->order);

        $this->assertInstanceOf("\Mpopa\Discount\CategoryAmount", $category_amount_object);

        $this->assertTrue($category_amount_object->isApplicable());
        $this->assertInternalType("boolean", $category_amount_object->isApplicable());

        /**
         * Test discount body
         */
        $discount_body = $category_amount_object->getDiscountBody();
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