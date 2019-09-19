# 2019-top-cat
A small web app that will show you pictures of cats!

## API scrape
### *APIScrape/scrape.php*

A command-line utility for creating the database for the Top Cat app.

* Makes API requests to get:
    * A list of cat breeds
    * Image URLs for cats from each breed

To use: 
`$ php scrape.php`
<br />
<br />

## DB class
### *Utilities/DB.php*

* DB class contains a PDO that connects to the database
<br />
<br />

## SQL to generate DB
### *ref/cats_2019-09-16-database-design.sql*

* Contains query to generate cat database for the app.
* The database contains two tables - breed, img

## Tests
To run tests use PHPUnit. 

Test files are found alongside the files they test, so run
`$ phpunit src`
to catch them all.