<?php

use \PHPUnit\Framework\TestCase;

class DiscountFactoryTest extends TestCase
{
    private $order;
    private $percentage_based_on_amount_data;
    private $category_amount_discount_data;
    private $cheapest_from_category_data;

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
        $this->assertInstanceOf("\Mpopa\Discount\CategoryAmount", \Mpopa\Discount\DiscountFactory::build($this->order));
    }

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
        $this->assertInstanceOf("\Mpopa\Discount\CheapestFromCategory", \Mpopa\Discount\DiscountFactory::build($this->order));
    }

    public function testPercentageBasedOnAmount()
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
        $this->assertInstanceOf("\Mpopa\Discount\PercentageBasedOnAmount", \Mpopa\Discount\DiscountFactory::build($this->order));
    }

    public function testNullDiscountCreation()
    {
        global $mysql_good_config;
        $this->cheapest_from_category_data = "{
            \"id\": \"3\",
            \"customer-id\": \"3\",
            \"items\": [
              {
                \"product-id\": \"A101\",
                \"quantity\": \"1\",
                \"unit-price\": \"9.75\",
                \"total\": \"9.75\"
              }
            ],
            \"total\": \"9.75\"
          }
          ";

        $this->order = new Mpopa\Order($this->cheapest_from_category_data, $mysql_good_config);
        $this->assertNull(\Mpopa\Discount\DiscountFactory::build($this->order));
    }
}
