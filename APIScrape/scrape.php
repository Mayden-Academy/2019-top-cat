<?php

require_once "../Utilities/DB.php";

$db = new DB();
$dbconnection = $db->dbConnect();

/**
 * Creates a new database into which to put the scraped data.
 * If the database already exists, tears it down and creates a new one.
 */
function createDatabase(PDO $db) {
    try {
        $sql = "DROP DATABASE IF EXISTS `cat-test`;
                CREATE DATABASE `cat-test`;
                
                USE `cat-test`;
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
        $db->exec($sql);
        echo "Database successfully initialised.";
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

/**
 * Make API request to get all of the breeds from theCatAPI.
 * 
 * @return array of breeds as 4-character breed id => breed name
 * e.g. "ABYS" => "Abyssinian"
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
 * Puts the list of breeds into the database.
 * 
 * @param PDO $db - the database to insert into.
 * @param array $catBreeds - the list of cat breeds. As breed id => breed name.
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
 * Use the list of cat breeds to make the API requests so we can get URLs
 * of cat pictures to hotlink in the app.
 * 
 * @param array of cat breeds
 * @return array of breed names => array of strings representing the image URLs
 */
function getCatImgURLs(array $catBreeds):array
{
    $imageSourceArray = [];
    foreach ($catBreeds as $id => $name) {
        $catImageApiUrl = 'https://api.thecatapi.com/v1/images/search?breed_ids=' . $id . '&limit=21';
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $catImageApiUrl,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => array(
                'x-api-key: ec254e44-3996-458b-8522-4933954d8fcd'
            ),
        ));
        $imageApiResponse = curl_exec($curl);
        $error = curl_error($curl);
        curl_close($curl);

        $responseArray = json_decode($imageApiResponse, true);

        $breedImages = [];
        foreach($responseArray as $item) {
            array_push($breedImages, $item["url"]);
        }
        $imageSourceArray[$name] = $breedImages;
    }
    return $imageSourceArray;
}

/**
 * Puts the cat image URLs into the database.
 * 
 * @param PDO $db the database to use
 * @param array The list of cat breeds
 * @param array The list of cat img URLs
 * @return void
 */
function fillCatImages(PDO $db, array $catBreedArray, array $catImageSourceArray)
{
    $catBreedIndexedArray = [];
    foreach($catBreedArray as $breed) {
        $catBreedIndexedArray[] = $breed;
    }
    $sqlArray = [];
    for($breedIndex = 0; $breedIndex < count($catImageSourceArray); $breedIndex++) {
        foreach($catImageSourceArray[$catBreedIndexedArray[$breedIndex]] as $url) {
            $breedID = $breedIndex + 1;
            $sqlArray[] = "('$url', $breedID)";
        }
    }
    $sqlString = implode(',', $sqlArray);
    $sql = $db->prepare('INSERT INTO `img` (img_src, breed_id) VALUES ' . $sqlString . ';');
    $sql->execute();
    echo "Cat image URLs added to database.";
}

// Do the business:
createDatabase($dbconnection);
$breeds = getCatBreeds();
fillCatBreedToDB($dbconnection, $breeds);
$catImageSourceArray = getCatImgURLs($breeds);
fillCatImages($dbconnection, $breeds, $catImageSourceArray);
