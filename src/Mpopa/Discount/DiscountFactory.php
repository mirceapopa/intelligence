<?php
namespace Mpopa\Discount;

/**
 * This Factory is responsable for returning the appropiate discount object type in Order class
 * All discounts must return same fields, as defined in Discount base class
 */
class DiscountFactory
{
    /**
     * Discounts are not cumulative
     */
    public static function build(\Mpopa\Order $order) : ?Object
    {
        /**
         * Requirement 1: A customer who has already bought for over € 1000, gets a discount of 10% on the whole order.
         * More explanations in the PercentageBasedOnAmount class
         */
        $discount_percent = new PercentageBasedOnAmount($order);
        if($discount_percent->isApplicable()){
            return $discount_percent;
        }
        unset($discount_percent);

        /**
         * Requirement 2: For every product of category "Switches" (id 2), when you buy five, you get a sixth for free.
         * More explanations in the CategoryAmount class
         */
        $discount_category = new CategoryAmount($order);
        if($discount_category->isApplicable()){
            return $discount_category;
        }
        unset($discount_category);

        /**
         * Requirement 3: If you buy two or more products of category "Tools" (id 1), you get a 20% discount on the cheapest product.
         * More explanations in the CheapestFromCategory class
         */
        $discount_cheapest = new CheapestFromCategory($order);
        if($discount_cheapest->isApplicable()){
            return $discount_cheapest;
        }
        unset($discount_cheapest);

        return null;
    }
}
