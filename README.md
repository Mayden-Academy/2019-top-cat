# 2019-top-cat


## API scrape
### *APIScrape/scrape.php*

* Send API request to get the data below
    * List of cat breeds
    * All the img src url of all the cat breeds
    
* To run the script you must already have a database by the name `cat-test`
* Then type in the command line 
**(You must be inside the APIScrape directory)**

    ```$ php scrape.php ```
<br />
<br />

## DB class
### *Utilities/DB.php*

* DB class contains a PDO that connects to the database
<br />
<br />

## SQL to generate DB
### *ref/cat-test_2019-09-16-database-design.sql*

* Contains query to generate cat database for the app.
* The database contains two tables - breed, img