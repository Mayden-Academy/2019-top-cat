<?php

require_once "../Utilities/DB.php";

$db = new DB();
$dbconnection = $db->dbConnect();

/**
 * Creates a new database into which to put the scraped data.
 * If the database already exists, tears it down and creates a new one.
 */
function createDatabase(PDO $dbconnection) {
    try {
        //$conn = new PDO("mysql:host=192.168.20.20", $username, $password);
        //$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "DROP DATABASE IF EXISTS `cat-test`;
                CREATE DATABASE `cat-test`;
                
                use `cat-test`;
                CREATE TABLE `breed` (
                `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                `breed` varchar(255) NOT NULL DEFAULT '',
                PRIMARY KEY (`id`),
                UNIQUE KEY `breed` (`breed`)
                ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
               
                CREATE TABLE `img` (
                `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                `img_src` varchar(255) NOT NULL DEFAULT '',
                `breed_id` int(11) unsigned NOT NULL,
                PRIMARY KEY (`id`),
                UNIQUE KEY `img_src` (`img_src`)
                ) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
    
        $dbconnection->exec($sql);
        echo "Database successfully initialised.";
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

/**
 * Send API request to the CatAPI
 * Expected response is the JSON of all the cat breed id - which is the abbreviation of breed name (first four characters of the name)
 * Changed JSON response to an array = $responseArray
 * Return an associative array of breed id as $key and breed name as $ value
 * @return array
 */
function getCatBreeds():array
{
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.thecatapi.com/v1/breeds/",
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => array(
            'x-api-key: ec254e44-3996-458b-8522-4933954d8fcd'
        ),
    ));
    $response = curl_exec($curl);
    $error = curl_error($curl);
    curl_close($curl);

    $responseArray = json_decode($response, true);

    $associativeBreedArray = [];
    for ($i = 0; $i < count($responseArray); $i++) {
        $associativeBreedArray[$responseArray[$i]["id"]] = $responseArray[$i]["name"];
    }
    return $associativeBreedArray;
}

/**
 * Get DB connection from the dbConnect() method
 * Get the return value of getCatBreed() method
 * Fill the data into breed table
 * @return void
 */
function fillCatBreedToDB(PDO $db, array $catBreeds)
{
    foreach($catBreeds as $id => $breed) {
        $sql = $db->prepare('INSERT INTO `breed` (breed) VALUES (\'' . $breed . '\');');
        $sql->execute();
    }
    echo "Cat breeds added to database.";
}

/**
 * Get the return value of getCatBreed() method
 * Use the breed id to use it in the API url to send the request
 * Make the response into an array
 * Return an associative array of breed name as the $key and all the image source url belongs to that breed as $value(which is in array format)
 * @return array
 */
function getCatImgURLs(array $catBreeds):array
{
    $imgSrcArray = [];
    foreach ($catBreeds as $id => $name) {
        $catImgApiUrl = 'https://api.thecatapi.com/v1/images/search?breed_ids=' . $id . '&limit=21';
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $catImgApiUrl,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => array(
                'x-api-key: ec254e44-3996-458b-8522-4933954d8fcd'
            ),
        ));
        $imgApiResponse = curl_exec($curl);
        $error = curl_error($curl);
        curl_close($curl);

        $responseArray = json_decode($imgApiResponse, true);

        $breedImgs = [];
        foreach($responseArray as $item) {
            array_push($breedImgs, $item["url"]);
        }
        $imgSrcArray[$name] = $breedImgs;
    }
    return $imgSrcArray;
}

/**
 * Get DB connection from the dbConnect() method
 * Get the return value from getCatImg() method
 * Get the return value of getCatBreed() method, turn it into an indexed array
 * Create a new array $sqlArray which is the array of strings consist of 'img url($url)' and 'breed id($breedID)' that will be pushed to database directly as is
 * @return void
 */
function fillCatImg(PDO $db, array $catBreedArray, array $catImgSrcArray)
{
    $catBreedIndexedArray = [];
    foreach($catBreedArray as $breed) {
        $catBreedIndexedArray[] = $breed;
    }
    $sqlArray = [];
    for($breedIndex = 0; $breedIndex < count($catImgSrcArray); $breedIndex++) {
        foreach($catImgSrcArray[$catBreedIndexedArray[$breedIndex]] as $url) {
            $breedID = $breedIndex + 1;
            $sqlArray[] = "('$url', $breedID)";
        }
    }
    $sqlString = implode(',', $sqlArray);
    $sql = $db->prepare('INSERT INTO `img` (img_src, breed_id) VALUES ' . $sqlString . ';');
    $sql->execute();
}


// Do the business:
createDatabase($dbconnection);


$breeds = getCatBreeds();
fillCatBreedToDB($dbconnection, $breeds);
$catImgSrcArray = getCatImgURLs($breeds);
fillCatImg($dbconnection, $breeds, $catImgSrcArray);

