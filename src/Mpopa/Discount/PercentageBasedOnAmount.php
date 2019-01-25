<?php
namespace Mpopa\Discount;

/**
 * Requirement 1: A customer who has already bought for over € 1000, gets a discount of 10% on the whole order.
 * 
 * The class receives $percentage (defaults to 10) and $minumum_order (defaults to 1000) parameters
 * The parameters can be changed. Ex: PercentageBasedOnAmount($order, 20, 2000) will apply a 20% discount
 * to an order of 2000 or more.
 * 
 * NOTE: Discounts are not cumulative.
 */
class PercentageBasedOnAmount extends Discount{
    /**
     * Discount percentage
     */
    private $percentage;

    /**
     * Minumum amount for the discount to be applied
     */
    private $minumum_order;

    public function __construct(\Mpopa\Order &$order, $percentage = 10, $minumum_order = 1000){
        $this->order = $order;
        $this->minumum_order = $minumum_order;
        $this->percentage = $percentage;
    }

    /**
     * Checks if discount applies
     */
    public function isApplicable() : bool{
        if($this->order->getTrueTotal() >= $this->minumum_order){
            $this->is_applicable = true;
            $this->calculateDiscount();
            return true;            
        }
        return false;
    }

    /**
     * Calculates discount values
     */
    protected function calculateDiscount() : void{
        $discount = $this->order->getTrueTotal() * ($this->percentage / 100);
        $new_total = $this->order->getTrueTotal() - $discount;

        $this->order_discount_value = $discount;
        $this->order_discount_percentage = $this->percentage;
        $this->order_discount_reason = "Your order exceedes €" . $this->minumum_order . ". You get " . $this->percentage . "% off.";
        $this->order_new_total = $new_total;
    }

}