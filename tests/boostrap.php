<?php

/**
 * Test configuration for good MySQL connection
 */
$mysql_good_config = (object) array(
    'datasource' => 'mysql',
    'mysql' => (object) array(
        'db_host' => 'localhost',
        'db_name' => 'mpopa_intelligence',
        'db_user' => 'root',
        'db_pass' => 'root',
    ),
);

/**
 * Test configuration for wrong MySQL connection
 */
$mysql_wrong_config = (object) array(
    'datasource' => 'mysql',
    'mysql' => (object) array(
        'db_host' => 'localhost',
        'db_name' => 'mpopa_intelligence',
        'db_user' => 'root3',
        'db_pass' => '',
    ),
);

/**
 * Test configuration for good JSON files
 */
$json_good_config = (object) array(
    'datasource' => 'json',
    'json' => (object) array(
        'products_source' => 'https://raw.githubusercontent.com/teamleadercrm/coding-test/master/data/products.json',
        'customers_source' => 'https://raw.githubusercontent.com/teamleadercrm/coding-test/master/data/customers.json',
    ));


/**
 * Test configuration for wrong JSON files
 */
$json_wrong_config = (object) array(
    'datasource' => 'json',
    'json' => (object) array(
        'products_source' => 'missing_products.json',
        'customers_source' => 'missing_customers.json',
    ));

/**
 * Composer autoloader
 */

$loader = require 'vendor/autoload.php';
$loader->add('Mpopa\\', 'src/');

/**
 * Config variables
 */
include "config.php";
