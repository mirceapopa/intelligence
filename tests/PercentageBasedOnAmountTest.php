<?php

use \PHPUnit\Framework\TestCase;

class PercentageBasedOnAmountTest extends TestCase
{
    private $order;
    private $percentage_based_on_amount_data;

    public function testPercentageBasedOnAmountCreation()
    {
        global $mysql_good_config;
        $this->percentage_based_on_amount_data = "{
            \"id\": \"2\",
            \"customer-id\": \"2\",
            \"items\": [{
                \"product-id\": \"B102\",
                \"quantity\": \"1000\",
                \"unit-price\": \"4.99\",
                \"total\": \"4990\"
            }],
            \"total\": \"4990\"
        }";

        $this->order = new Mpopa\Order($this->percentage_based_on_amount_data, $mysql_good_config);
        $percentage_based_on_amount_object = \Mpopa\Discount\DiscountFactory::build($this->order);

        $this->assertInstanceOf("\Mpopa\Discount\PercentageBasedOnAmount", $percentage_based_on_amount_object);
        $this->assertTrue($percentage_based_on_amount_object->isApplicable());
        $this->assertInternalType("boolean", $percentage_based_on_amount_object->isApplicable());

        /**
         * Test discount body
         */
        $discount_body = $percentage_based_on_amount_object->getDiscountBody();
        $this->assertInternalType("array", $discount_body);

        $this->assertArrayHasKey('status', $discount_body);
        $this->assertArrayHasKey('value', $discount_body);
        $this->assertArrayHasKey('percentage', $discount_body);
        $this->assertArrayHasKey('reason', $discount_body);
        $this->assertArrayHasKey('new_total', $discount_body);
        $this->assertArrayHasKey('error_message', $discount_body);

        $this->assertInternalType("string", $discount_body["status"]);
        $this->assertInternalType("float", $discount_body["value"]);
        $this->assertInternalType("integer", $discount_body["percentage"]);
        $this->assertInternalType("string", $discount_body["reason"]);
        $this->assertInternalType("float", $discount_body["new_total"]);
        $this->assertInternalType("string", $discount_body["error_message"]);
    }
}
