<?php
namespace Mpopa;

/**
 * This class handles the operations done on Products data
 */
class Products
{
    private $products;
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
     * Fetches all products from the datasource
     */
    public function fetchData() : void
    {
        $this->products = $this->data_handler->getProducts();
    }

    public function getProducts() : ?array {
        return $this->products;
    }

    /**
     * Verifies the authenticity of a product
     */
    public function verifyProduct($product) : bool
    {
        return $this->data_handler->verifyProduct($product);
    }

    public function getProductById($product_id) : ?array
    {
        return $this->data_handler->getProductById($product_id);
    }
}