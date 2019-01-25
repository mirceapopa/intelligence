<?php
namespace Mpopa\DataSource;

/**
 * Class for handling the connections to a MySQL Database
 */
final class MySQL implements DataSourceInterface
{
    private $products = null;
    private $customers = null;
    private $db = null;

    public function __construct($config)
    {
        try {
            $this->db = new \PDO("mysql:host=" . $config->{$config->datasource}->db_host .
                ";dbname=" . $config->{$config->datasource}->db_name,
                $config->{$config->datasource}->db_user,
                $config->{$config->datasource}->db_pass);
            $this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            throw new \Mpopa\ExpException("Could not connect to database: " . $e->getMessage());
        }
    }

    /**
     * Retrieves the list of customers
     */
    public function getCustomers(): array
    {
        try {
            $statement = $this->db->prepare("select * from customers");
            $statement->execute();
            return $this->customers = $statement->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            throw new \Mpopa\ExpException("Can't get customers: " . $e->getMessage());
        }
    }

    /**
     * Retrieves the list of products
     */
    public function getProducts(): array
    {
        try {
            $statement = $this->db->prepare("select * from products");
            $statement->execute();
            return $this->products = $statement->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            throw new \Mpopa\ExpException("Can't get products: " . $e->getMessage());
        }
    }

    /**
     * Verifies the product, if it exists in the database
     */
    public function verifyProduct($product): bool
    {
        $prod = $this->getProductById($product["product-id"]);
        if ($prod["price"] == $product["unit-price"] &&
            \Mpopa\Helper::compareFloats($product["total"], ($prod["price"] * $product["quantity"]))
        ) {
            return true;
        }
        return false;
    }

    /**
     * Retrieves a product based on it's ID
     */
    public function getProductById($product_id): ?array
    {
        try {
            $statement = $this->db->prepare("select * from products where `id` = :id");
            $statement->bindParam(':id', $product_id, \PDO::PARAM_STR, 4);
            $statement->execute();
            $res = $statement->fetch(\PDO::FETCH_ASSOC);
            return $res !== false ? $res : null;
        } catch (\PDOException $e) {
            throw new \Mpopa\ExpException("Can't get product: " . $e->getMessage());
        }
        return null;
    }

    /**
     * Retrieves a customer based on it's ID
     */
    public function verifyCustomer($customer_id): bool
    {
        try {
            $statement = $this->db->prepare("select * from customers where `id` = :id");
            $statement->bindParam(':id', $customer_id, \PDO::PARAM_INT);
            $statement->execute();
            return $statement->fetch(\PDO::FETCH_ASSOC) !== false ? true : false;
        } catch (\PDOException $e) {
            throw new \Mpopa\ExpException("Can't get product: " . $e->getMessage());
        }
        return false;
    }
}
