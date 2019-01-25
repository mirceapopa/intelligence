<?php
namespace Mpopa\Discount;

/**
 * Requirement 3: If you buy two or more products of category "Tools" (id 1), you get a 20% discount on the cheapest product.
 * 
 * The class receives $category_id (defaults to 1) and $percentage (defaults to 20) parameters
 * If you call CheapestFromCategory($order, 4, 10), it will apply the same rule of disount, but for 
 * the 4th category, with a discount of 10 percent
 * 
 * NOTE: The discount is applied on only one of the cheapest product
 *       For example if the user buys 1 product which costs €10, and 10 products that individually cost €5, the user will
 *          receive a discount of 20% (or what value it receives) from the cheapest (€5)
 *       Discounts are not cumulative.
 */
class CheapestFromCategory extends Discount{
     /**
     * Category ID for discount
     */
    private $category_id;

    /**
     * Minimum number of products from category
     */
    private $products_nr;

    /**
     * Full discount value
     */
    private $discounted_value;

    /**
     * The item which will receive $percentage discount
     */
    private $item_discounted = [];

    /**
     * Items from the $category_id
     */
    private $items_matching = [];

    public function __construct(\Mpopa\Order &$order, $category_id = 1, $products_nr = 2, $percentage = 20){
        $this->order = $order;
        $this->percentage = $percentage;
        $this->category_id = $category_id;
        $this->products_nr = $products_nr;
    }

     /**
     * Checks if discount applies
     */
    public function isApplicable() : bool{
        $items = $this->order->getOrderItems();

        // 
        foreach($items as $item){
            $tmp_item = $this->order->getProductById($item["product-id"]);
            if((int)$tmp_item["category"] === $this->category_id){
                $this->items_matching[] = $tmp_item;
            }
        }

        // customer must order at least $products_nr different types of products from category $category_id
        if(count($this->items_matching) >= $this->products_nr){
            $this->is_applicable = true;
            // selects the cheapest item from the category
            $this->item_discounted = $this->items_matching[array_search(min(array_column($this->items_matching, 'price')), array_column($this->items_matching, 'price'))];
            $this->calculateDiscount();
            return true; 
        }
        return false;
    }
    
    /**
     * Calculates discount values
     */
    protected function calculateDiscount() : void{
        $discount = $this->item_discounted["price"] * ($this->percentage / 100);
        $new_total = $this->order->getTrueTotal() - $discount;
        $percentage = (100 - ($new_total * 100) / $this->order->getTrueTotal());

        $this->order_discount_value = $discount;
        $this->order_discount_percentage = $percentage;
        $this->order_discount_reason = "For every " . $this->products_nr . " or more different product types from category nr. " . $this->category_id . " you get " . $this->percentage . "% of the cheapest. It applies to one product only. ";
        $this->order_discount_reason .= "You received " . $this->percentage . "% (€" . $discount . ") off '" . $this->item_discounted["description"] . "' (priced €".$this->item_discounted["price"].").";
        $this->order_new_total = $new_total;
    }
}