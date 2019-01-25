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
1. Via GET request, including the URL to the order.json file as the "order" parameter
Example: <br>
```http://{project_url}/order=?php index.php "https://raw.githubusercontent.com/teamleadercrm/coding-test/master/example-orders/order3.json"```

2. Via command line, by giving the json file containing the order as a parameter
Example **(external file)**:
```
cd {project_folder}
php index.php "php index.php "https://raw.githubusercontent.com/teamleadercrm/coding-test/master/example-orders/order3.json"
```
or **(local file)**:
```cd {project_folder}
php index.php assets/order.json
```

3. Via POST request, by sending the order json as a "Content-Type" set to "application/json"<br>
For this example you can use any app that sends POST reqests, like Insomnia. Just make sure that you have the "Content-Type" set to "application/json"
