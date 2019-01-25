# TeamLeader Coding Test Problem 1 : Discounts

## Installation
Clone this repository in you preferred folder, e.g. /var/www/html<br>
`git clone https://github.com/mirceapopa/intelligence.git`<br>

Import the database dump to your mysql server. The dump can be found here:<br>
`{project_folder}/assets/database/mpopa_intelligence.sql.gz`
<br><br>
Change the MySQL config values with the user/password/host/database values that you use, or change the sources for the JSON files if you want to test it using JSON files as datasources in the following locations:<br>
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
