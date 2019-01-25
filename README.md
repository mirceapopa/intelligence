# TeamLeader Coding Test Problem 1 : Discounts

## Installation
Clone this repository in you preferred folder, e.g. `/var/www/html`<br>
`git clone https://github.com/mirceapopa/intelligence.git`<br>

Import the database dump to your mysql server (it will automatically create the DB). The dump can be found here:<br>
`{project_folder}/assets/database/mpopa_intelligence.sql.gz`
<br><br>
Change the MySQL config values with the `user/password/host/database` values that you use, or change the sources for the JSON files if you want to test it using JSON files as datasources in the following locations:<br>
- for running the example<br>
`{project_folder}/config.php`<br>
- for unit testing <br>
`{project_folder}/tests/boostrap.php`<br><br>

Run the unit tests:
`cd {project_folder}`<br>
`./vendor/bin/phpunit`<br><br>
It should output something like:<br>
```PHPUnit 7.5.2 by Sebastian Bergmann and contributors.

Runtime:       PHP 7.2.10-0ubuntu0.18.04.1
Configuration: /var/www/html/intelligence/phpunit.xml

..............................................                    46 / 46 (100%)

Time: 13.74 seconds, Memory: 4.00MB

OK (46 tests, 237 assertions)
```
## Running the example
This example can be ran in 3 different ways:
1. Via `GET` request, by passing the URL of the order.json file as the `order` parameter.<br>
Example: <br>
```http://{project_url}/?order=https://raw.githubusercontent.com/teamleadercrm/coding-test/master/example-orders/order3.json```

2. Via command line, by passing the json local file path or URL containing the order json file as a parameter.<br>
Example **(external file)**:
```
cd {project_folder}
php index.php "https://raw.githubusercontent.com/teamleadercrm/coding-test/master/example-orders/order3.json"
```
or **(local file)**:
```cd {project_folder}
php index.php "assets/order.json"
```

3. Via `POST` request, by sending the order json as a `Content-Type` set to `application/json`<br>
For this example you can use any app that sends `POST` reqests, like `Insomnia`. Just make sure that you have the `Content-Type` set to `application/json`

Either way, this api will return a JSON response.

## How it works
Basically, it receives an order like the ones in your example, and returns another json with the discount (if it was applied), or an error if something isn't right.<br>
There are 3 types of discounts:<br>
 **1: A customer who has already bought for over € 1000, gets a discount of 10% on the whole order.**<br>
 The class receives $percentage (defaults to 10) and $minumum_order (defaults to 1000) parameters.<br>
 The parameters can be changed. Ex: PercentageBasedOnAmount($order, 20, 2000) will apply a 20% discount to an order of 2000 or more.<br><br>
 
 **2: For every product of category "Switches" (id 2), when you buy five, you get a sixth for free.**<br>
  The class receives $category_id (defaults to 2) and $products_nr (defaults to 5) parameters.<br>
  If you call CategoryAmount($order, 4, 10), it will apply the same rule of disount, but for the 4th category, and for a group of 10 items.<br>
  It applies for every individual product type. For example if a customer orders 5xBasic on-off switch and 7xPress button, the discount will include 1x Basic on-off switch and also 1xPress button.<br>
  **NOTE:** If the customer orders for example 10 products from category 2, the customer will receive 2 more free (one for each 5 products group).<br>
   If the customer orders 7 products for example, it will receive only 1 free, because only one full group of 5 products was bought.<br>


