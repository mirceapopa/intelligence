<?php
namespace Mpopa;

/**
 * This class handles the operations done on Customers data
 */
class Customers
{
    private $customers;
    /**
     * Provides access to datasource functions
     */
    private $data_handler;

    public function __construct($config)
    {
        // access to the datasource
        $this->data_handler = DataSource\DataSourceFactory::build($config);
    }

    /**
     * Fetches all customers from the datasource
     */
    public function fetchData() : void
    {
        $this->customers = $this->data_handler->getCustomers();
    }

    public function getCustomers() : ?array {
        return $this->customers;
    }

    /**
     * Verifies the authenticity of a customer
     */
    public function verifyCustomer($customer_id) : bool
    {
        return $this->data_handler->verifyCustomer($customer_id);
    }
}
