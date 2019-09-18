# 2019-top-cat

##### API scrape `APIScrape/scrape.php`

* Send API request to CatAPI using cURL

* Get response from the CatAPI
    * List of cat breeds
    * All the img src url of all the cat breeds
    
* Fill the DB tables ( breed, img ) with the sanitized data from the process above

* To run it, in the command line type 
**(you must be inside the APIScrape directory)**
``` php scrape.php ```
    
    
##### DB class `Utilities/DB.php`

* DB class contains a PDO that connects to the database
