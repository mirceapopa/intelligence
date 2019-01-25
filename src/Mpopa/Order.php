<?php
namespace Mpopa;

/**
 * This class handles the operations done on the incoming order
 */
class Order
{
    private $id;
    private $customer_id;
    private $items;
    private $total;
    private $products;
    private $customers;
    private $discount = null;

    public function __construct($order_json, $config)
    {
        Helper::isJSON($order_json);

        $order = json_decode($order_json, true);
        $this->verifyOrderIntegrity($order);

        $this->id = (int) $order["id"];
        $this->customer_id = (int) $order["customer-id"];
        $this->items = (array) $order["items"];
        $this->total = (float) $order["total"];

        $this->products = new Products($config);
        $this->customers = new Customers($config);
        $this->verifyOrderData();
    }

    public function calculateDiscount() : array
    {
        $dis = Discount\DiscountFactory::build($this);
        return $this->discount = $dis !== null ? $dis->getDiscountBody() : Discount\Discount::getDefaultDiscount();
    }

    public function getOrderDiscount() : array
    {
        return $this->discount !== null ? $this->discount : $this->calculateDiscount();
    }

    public function getProducts() : Products
    {
        return $this->products;
    }

    public function getTrueTotal() : float
    {
        return $this->total;
    }

    public function getProductById($product_id): ?array
    {
        return $this->products->getProductById($product_id);
    }

    public function getOrderItems(): array
    {
        return $this->items;
    }

    /**
     * Checks if the order is properly formatted and has all fields and keys
     * It also checks the products in the database
     */
    public function verifyOrderIntegrity($order_json): bool
    {
        // check order array keys
        if (!(Helper::validateArrayKeys(["id", "customer-id", "items", "total"], $order_json))) {
            throw new ExpException("Invalid order array keys: " . json_encode($order_json));
        }

        // check order array data types
        if (!(Helper::isIntegerAndPositive($order_json["id"]) &&
            Helper::isIntegerAndPositive($order_json["customer-id"]) &&
            Helper::isFloatAndPositive($order_json["total"]))) {
            throw new ExpException("Invalid order value types: " . json_encode($order_json));
        }

        // order should have at least 1 product
        if (count($order_json["items"]) == 0) {
            throw new ExpException("Order should have at least one item in items array.");
        }

        // checking the items from order
        foreach ($order_json["items"] as $item) {
            // check item array keys
            if (!(Helper::validateArrayKeys(["product-id", "quantity", "unit-price", "total"], $item))) {
                throw new ExpException("Invalid order item keys: " . json_encode($item));
            }

            // check item array data types
            if (!(preg_match("/^[A-Z][0-9]{3}$/", $item["product-id"]) &&
                Helper::isIntegerAndPositive($item["quantity"]) &&
                Helper::isFloatAndPositive($item["unit-price"]) &&
                Helper::isFloatAndPositive($item["total"]))) {
                throw new ExpException("Invalid order array value types for item in items array: " . json_encode($item));
            }
        }

        return true;
    }

    /**
     * Verifies the data held in the order json
     * Including items and total price
     */
    public function verifyOrderData(): bool
    {
        $true_total = 0;

        // validate individual products against the Products data
        foreach ($this->items as $item) {
            // checks if there aren't any dupllicate items
            if(array_count_values(array_column($this->items, 'product-id'))[$item["product-id"]] > 1){
                throw new ExpException("Multiple instances of the same item found: " . json_encode($item));
            }

            if (!$this->products->verifyProduct($item)) {
                throw new ExpException("Invalid product data: " . json_encode($item));
            }
            $true_total += $item["unit-price"] * $item["quantity"];
        }

        // validates the total from order        
        if (!\Mpopa\Helper::compareFloats($true_total, $this->total)) {
            throw new ExpException("Invalid total price: " . (string) $this->total . ". Should be: " . (string) $true_total);
        }

        // validates the customer against the Customer data
        if (!$this->customers->verifyCustomer($this->customer_id)) {
            throw new ExpException("Invalid customer-id: " . (string) $this->customer_id);
        }

        return true;
    }

}
