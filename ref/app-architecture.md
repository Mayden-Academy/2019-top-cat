
Index.php
    Instantiate DB connection object
    Pulls breed list (as array of strings) from DB using DB connection object
    If breed selection given:
        Give CatHydrator the DB connection object and return the list of CatEntity objects
        Add main HTML for Top Cat page
    Translate breed list to HTML inline
    Translate Cats to HTML inline
Composer.json
APIScrape/
    scrape.php
    readme.md
Vendor/ - (directory)
Entities/ - (directory/Namespace)
    CatEntity.php - ENTITY CLASS
        Contains properties:
            ID
            img url
            Breed
        Contains Getters for above
    CatEntityTest.php
Utilities/ - (directory/Namespace)
    DB.php
        Class for object that creates connection to Cat database
Hydrators/ - (directory/Namespace)
    CatHydrator.php
        static function makeListOfCats($db)
        Takes a database-wrapper and returns an array of CatEntity objects.


