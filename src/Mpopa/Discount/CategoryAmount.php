<?php
namespace Mpopa\Discount;

/**
 * Requirement 2: For every product of category "Switches" (id 2), when you buy five, you get a sixth for free.
 * 
 * The class receives $category_id (defaults to 2) and $products_nr (defaults to 5) parameters.
 * If you call CategoryAmount($order, 4, 10), it will apply the same rule of disount, but for 
 * the 4th category, and for a group of 10 items.
 * 
 * It applies for every individual product type. For example if a customer orders 5xBasic on-off switch and 7xPress button, the discount will
 * include 1x Basic on-off switch and also 1xPress button
 * 
 * NOTE: If the customer orders for example 10 products from category 2, the customer will receive 2 more free (one for each 5 products group).
 *       If the customer orders 7 products for example, it will receive only 1 free, because only one full group of 5 products was bought
 *       Discounts are not cumulative.
 */
class CategoryAmount extends Discount {
    /**
     * Category ID for discount
     */
    private $category_id;

    /**
     * Quanity if products for which discount applies
     */
    private $products_nr;

    /**
     * Full discount value
     */
    private $discounted_value;

    /**
     * Discounted items
     */
    private $items_matching = [];

    public function __construct(\Mpopa\Order &$order, $category_id = 2, $products_nr = 5){
        $this->order = $order;
        $this->category_id = $category_id;
        $this->products_nr = $products_nr;
    }

    /**
     * Checks if discount applies
     */
    public function isApplicable() : bool{
        $items = $this->order->getOrderItems();
        foreach($items as $item){
            // checks every item for order if the quantity is >= $products_nr
            if($item["quantity"] >= $this->products_nr){
                $tmp_item = $this->order->getProductById($item["product-id"]);

                // checks if product category equals $category_id 
                if((int)$tmp_item["category"] === $this->category_id){
                    $tmp_item["qty"] = $item["quantity"];

                    // saves the discounted items in a temporary array
                    $this->items_matching[] = $tmp_item;

                    // stores the total cost of the discount
                    $this->discounted_value += $tmp_item["price"] * floor($item["quantity"] / $this->products_nr);
                }
            }
        }

        if($this->discounted_value > 0){
            $this->is_applicable = true;
            $this->calculateDiscount();
            return true; 
        }
        return false;
    }

    /**
     * Calculate discount values
     * For this type of discount, it calculates the discount percentage and total value
     * based on what the customer would have paid if the free items were payed also
     */
    protected function calculateDiscount() : void{
        $percentage = ($this->discounted_value * 100) / $this->order->getTrueTotal();
        $new_total = $this->order->getTrueTotal() - $this->discounted_value;

        $this->order_discount_value = $this->discounted_value;
        $this->order_discount_percentage = $percentage;
        $this->order_discount_reason = "For every " . $this->products_nr . " products from category #" . $this->category_id . " you get one free. You got: ";
        foreach($this->items_matching as $item){
            $this->order_discount_reason .= floor($item["qty"] / $this->products_nr) . " x '" . $item["description"] . "' (€". $item["price"] ." each) ; ";
        }
        $this->order_new_total = $new_total;
    }
}