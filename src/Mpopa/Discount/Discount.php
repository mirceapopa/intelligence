<?php
namespace Mpopa\Discount;

/**
 * Base class for any discount
 * Any added discount must inherit it
 */
abstract class Discount{
    /**
     * Value in euros of the discount
     */
    protected $order_discount_value = 0;

    /**
     * Percentage of the discount based on total value
     */
    protected $order_discount_percentage = 0; 

    /**
     * If the order isn't eligible for any discounts
     * this field will remain false
     */
    protected $is_applicable = false;
    
    /**
     * Explanation of the discount
     */
    protected $order_discount_reason = "No discount applied.";
    /**
     * New order total after discount was applied
     */
    protected $order_new_total = 0;  

    /**
     * Method for checking if a certain discount applies
     */
    public abstract function isApplicable() : bool;

    /**
     * Calculate discount value
     */
    protected abstract function calculateDiscount() : void;

    public function getDiscountValue(){
        return $this->order_discount_value;
    }

    public function getDiscountPercentage(){
        return $this->order_discount_percentage;
    }

    public function getDiscountReason(){
        return $this->order_discount_reason;
    }

    public function getNewTotal(){
        return $this->order_new_total;
    }

    public function getDiscountBody(){
        $discount["status"] = "applied";
        $discount["value"] = $this->order_discount_value;
        $discount["percentage"] = $this->order_discount_percentage;
        $discount["reason"] = $this->order_discount_reason;
        $discount["new_total"] = $this->order_new_total;
        $discount["error_message"] = "";

        return $discount;
    }

    static function getDefaultDiscount(){
        return  [
            "status" => "not_applied",
            "value" => 0,
            "percentage" => 0,
            "reason" => "",
            "new_total" => 0,
            "error_message" => ""
        ];
    }

    static function getErrorDiscount($error_message){
        return  [
            "status" => "error",
            "value" => 0,
            "percentage" => 0,
            "reason" => "",
            "new_total" => 0,
            "error_message" => $error_message
        ];
    }
}