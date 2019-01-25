<?php
header('Content-Type: application/json');

/**
* If {HIDE_ERRORS} = false, the user will see the {GENERIC_ERROR_MESSAGE}
* else, it will return the full error message
* errors can also be seen in {LOG_FILE} path regardless of the HIDE_ERRORS value
*/
define("HIDE_ERRORS", false);
/**
 * Message contained in "error_message" key if an error has occured
 * It's visible only if {HIDE_ERRORS} was set to true
 */
define("GENERIC_ERROR_MESSAGE", "An error occured while processing your request.");
/**
 * Minimum php version needed to run this example
 */
define("PHP_VERSION_MIN", "7.2.10");
/**
 * Log file location
 * Please check if file has appropiate permissions
 */
define("LOG_FILE", "log/api_error.log");

/**
 * Settings for debugging
 * Must be removed for production env
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('xdebug.var_display_max_depth', '10');
ini_set('xdebug.var_display_max_children', '256');
ini_set('xdebug.var_display_max_data', '1024');

/**
* Configurations for various data sources
* The example implements JSON & MySQL as datasources
* The pattern is:
* 'datasource' => 'DATA_SOURCE_NAME',
*     'DATA_SOURCE_NAME' => (object) array (
*         DATA_SOURCE_SPECIFIC_CONFIGURATIONS
*     )
*
* Example for JSON DATA SOURCE (replace with code after comment to test):
* JSON data source also accepts external json sources. 
* For example set 'products_source' value to 'https://raw.githubusercontent.com/teamleadercrm/coding-test/master/data/products.json'
* return (object) array(
*     'datasource' => 'json',
*     'json' => (object) array (
*         'products_source' => 'assets/products.json',
*         'customers_source' => 'assets/customers.json'
*     )
* );
*/
return (object) array(
    'datasource' => 'mysql',
    'mysql' => (object) array (
        'db_host' => 'localhost',
        'db_name' => 'mpopa_intelligence',
        'db_user' => 'root',
        'db_pass' => 'root',
    )
);