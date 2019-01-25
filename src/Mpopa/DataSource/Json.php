<?php
namespace Mpopa\DataSource;

/**
 * Class for handling the connections to json files holding
 * data about Customers and Products
 * The origin of the files can be configured in config.php
 *      - products: 'products_source'
 *      - customers: 'customers_source'
 */
final class Json implements DataSourceInterface
{
    private $products = null;
    private $customers = null;
    private $config = null;

    public function __construct($config){
        $this->config = $config;
    }

    /**
     * Since the data can come from an external source, this function
     * tests the integrity of the Customers JSON data
     */
    public function testCustomersData($data, $file_url)
    {
        // check if is a valid JSON
        \Mpopa\Helper::isJSON($data, $file_url);
        $customers = json_decode($data, true);

        // must contain at least 1 customer
        if(count($customers) == 0){
            throw new ExpException($file_url . " does not contain any customers.");                
        }

        // check each customer
        foreach($customers as $customer){
            // checks customer array keys
            if(!\Mpopa\Helper::validateArrayKeys(["id", "name", "since", "revenue"], $customer)){
                throw new ExpException("Invalid customer keys. " . json_encode($customer));
            }

            // check customer array data types
            if(!(\Mpopa\Helper::isIntegerAndPositive($customer["id"]) &&
                strlen($customer["name"]) >= 3 && 
                preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $customer["since"]) &&
                \Mpopa\Helper::isFloat($customer["revenue"])))
                {
                    throw new ExpException("Invalid customer values. " . json_encode($customer));
            }
        }
        return true;
    }

    /**
     * Since the data can come from an external source, this function
     * tests the integrity of the Products JSON data
     */
    public function testProductsData($data, $file_url)
    {
        // check if is a valid JSON
        \Mpopa\Helper::isJSON($data, $file_url);
        $products = json_decode($data, true);
        
        // must contain at least 1 product
        if(count($products) == 0){
            throw new ExpException($file_url . " does not contain any products.");                
        }

        // check each product
        foreach($products as $product){
            // checks product array keys
            if(!\Mpopa\Helper::validateArrayKeys(["id", "description", "category", "price"], $product)){
                throw new ExpException("Invalid product keys. " . json_encode($product));
            }

            // check product array data types
            if(!(
                preg_match("/^[A-Z][0-9]{3}$/", $product["id"]) &&
                strlen($product["description"]) >= 3 && 
                \Mpopa\Helper::isIntegerAndPositive($product["category"]) &&
                \Mpopa\Helper::isFloatAndPositive($product["price"])
                )){
                    throw new ExpException("Invalid product values." . json_encode($product));
            }
        }
        return true;
    }

    /**
     * Retrieves the list of customers
     */
    public function getCustomers() : array
    {
        $customers_json_url =$this->config->{$this->config->datasource}->customers_source;
        \Mpopa\Helper::fileExists($customers_json_url);
        $data = file_get_contents($customers_json_url);
        $this->testCustomersData($data, $customers_json_url);
        $this->customers = json_decode($data, true);
        return $this->customers;
    }

    /**
     * Retrieves the list of products
     */
    public function getProducts() : array
    {
        $products_json_url = $this->config->{$this->config->datasource}->products_source;
        \Mpopa\Helper::fileExists($products_json_url);
        $data = file_get_contents($products_json_url);
        $this->testProductsData($data, $products_json_url);
        $this->products = json_decode($data, true);
        return $this->products;
    }

    /**
     * Verifies the product, if it exists in the JSON file
     */
    public function verifyProduct($product) : bool
    {
        $this->getProducts();
        foreach ($this->products as $prod) {
            if ($prod["id"] == $product["product-id"] &&
                $prod["price"] == $product["unit-price"] &&
                number_format($product["total"]) == number_format($product["unit-price"] * $product["quantity"])
                ) {
                return true;
            }
        }
        return false;
    }

    /**
     * Retrieves a product based on it's ID
     */
    public function getProductById($product_id) : ?array
    {
        $this->getProducts();
        foreach ($this->products as $prod) {
            if ($prod["id"] == $product_id) {
                return $prod;
            }
        }
        return null;
    }
    
    /**
     * Retrieves a customer based on it's ID
     */
    public function verifyCustomer($customer_id) : bool
    {
        $this->getCustomers();
        foreach ($this->customers as $cust) {
            if ($cust["id"] == $customer_id) {
                return true;
            }
        }
        return false;
    }
}
