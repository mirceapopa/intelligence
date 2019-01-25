<?php
/**
 * The example checks for order JSON file link inside
 *      $_GET["order"] or $argv[1]
 *                  OR
 *      Json encoded file inside $_POST body
 * 
 * $_GET usage example:
 *      GET request http://{project_url}?order={link_to_order.json}
 *      Example: http://localhost/?order=https://raw.githubusercontent.com/teamleadercrm/coding-test/master/example-orders/order2.json
 * 
 * argv example
 *      From the command line, go to the project's folder and run 'php index.php "path/to/order.json"'
 *      Example: php index.php "assets/order.json". There are sebveral example json files inside "assets" folder
 * 
 * $_POST example
 *      With any application that simulates $_POST requests, send the order json inside the body
 *      Make sure that it has "Content-Type" set to "application/json"
 * 
 * The example returns an json formatted like this:
 *       [ 
 *           "status" => "not_applied|applied|error",
 *           "value" => 0,
 *           "percentage" => 0,
 *           "reason" => "",
 *           "new_total" => 0,
 *           "error_message" => ""
 *       ];
 */
ob_start();
$config = include('config.php');

if (version_compare(phpversion(), PHP_VERSION_MIN, '<')) {
    die(json_encode(["error" => "Please use php version " . PHP_VERSION_MIN . " or newer"]));
}

/**
 * Composer autoloader
 */
$loader = require 'vendor/autoload.php';
$loader->add('Mpopa\\', __DIR__.'/src/');

/**
 * Return data
 */
$discount = [];

try {
    /**
     * Calculate discount
     */
    $data = Mpopa\Helper::getRequestOrder($_GET, ($argv ?? null), $_POST);
    $discount = (new Mpopa\Order($data, $config))->calculateDiscount();
}
catch (Mpopa\ExpException $e){
    header('HTTP/1.0 403 Forbidden');
    $discount = Mpopa\Discount\Discount::getErrorDiscount($e->getMessage());
}

/**
 * Return discount data as json
 */
echo json_encode($discount);
ob_end_flush();