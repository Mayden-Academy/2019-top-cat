# 2019-top-cat


## API scrape
### *APIScrape/scrape.php*

A command-line utility for creating the database for the Top Cat app.

* Makes API requests to get:
    * A list of cat breeds
    * Image URLs for cats from each breed

To use: 
1. Make sure you are in the APIScrape directory
2. `$ php scrape.php`
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