<?php
namespace Mpopa\DataSource;

/**
 * Interface for classes which will access the datasources, like MySQL, JSON, SQL Server, etc
 * For now, I have implemented MySQL and JSON
 * See config.php for more details on how to change the datasource
 */
interface DataSourceInterface {
    /**
     * Retrieves the list of customers
     */
    public function getCustomers() : array;

    /**
     * Retrieves the list of products
     */
    public function getProducts() : array;
    
    /**
     * Verifies the product, if it exists in the database
     */
    public function verifyProduct($product) : bool;

    /**
     * Retrieves a product based on it's ID
     */
    public function getProductById($product_id) : ?array;

    /**
     * Retrieves a customer based on it's ID
     */
    public function verifyCustomer($customer_id) : bool;
}