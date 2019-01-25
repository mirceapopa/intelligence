# TeamLeader Coding Test Problem 1 : Discounts

## Installation
Clone this repository in you preferred folder, e.g. /var/www/html<br>
`git clone https://github.com/mirceapopa/intelligence.git`

Import the database file from <br>
`{project_folder}/assets/database/mpopa_intelligence.sql.gz`

Change the config values with the user/password/host/database values or change the sources for the JSON files if you want to test it using JSON files as datasources from<br>
`{project_folder}/config.php`<br>
and<br>
`{project_folder}/tests/boostrap.php`<br>

Run the unit tests:
`cd {project_folder}`<br>
`./vendor/bin/phpunit`<br>
It should output something like:<br>
```PHPUnit 7.5.2 by Sebastian Bergmann and contributors.

Runtime:       PHP 7.2.10-0ubuntu0.18.04.1
Configuration: /var/www/html/intelligence/phpunit.xml

..............................................                    46 / 46 (100%)

Time: 13.74 seconds, Memory: 4.00MB

OK (46 tests, 237 assertions)
```
