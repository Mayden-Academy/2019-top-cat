<?php

$servername = "localhost";
$username = "root";
$password = "";



try {
    $conn = new PDO("mysql:host=192.168.20.20", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "DROP DATABASE IF EXISTS `CatDB`;
            CREATE DATABASE `CatDB`;
            
            use `CatDB`;
            CREATE TABLE `breed` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `breed` varchar(255) NOT NULL DEFAULT '',
            PRIMARY KEY (`id`),
            UNIQUE KEY `breed` (`breed`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
            
           
            CREATE TABLE `img` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `img-src` varchar(255) NOT NULL DEFAULT '',
            `breed_id` int(11) unsigned NOT NULL,
            PRIMARY KEY (`id`),
            UNIQUE KEY `img-src` (`img-src`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1;";

    $conn->exec($sql);
    echo "Database successfully initialised.<br>";
} catch (PDOException $e) {
    echo "<br>" . $e->getMessage();
}


    /**
     * Send API request to the CatAPI
     * Expected response is the JSON of all the cat breed id - which is the abbreviation of breed name (first four characters of the name)
     * Changed JSON response to an array = $responseArray
     * Return an associative array of breed id as $key and breed name as $ value
     * @return array
     */
    public function getCatBreed()
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
        $breedArray = [];
        $breedNameArray = [];
        for ($i = 0; $i < count($responseArray); $i++) {
            array_push($breedArray, $responseArray[$i]["id"]);
            array_push($breedNameArray, $responseArray[$i]["name"]);
        }
        $associativeBreedArray = array_combine($breedArray, $breedNameArray);
        return $associativeBreedArray;
    }

    /**
     * Get DB connection from the dbConnect() method
     * Get the return value of getCatBreed() method
     * Fill the data into breed table
     * @return void
     */
    public function fillCatBreedToDB($catBreeds)
    {
        $dbconnect = $this->dbConnect();
        foreach($catBreeds as $id => $breed) {
            $sql = $dbconnect->prepare('INSERT INTO `breed` (breed) VALUES (\'' . $breed . '\');');
            $sql->execute();
        }
    }

    /**
     * Get the return value of getCatBreed() method
     * Use the breed id to use it in the API url to send the request
     * Make the response into an array
     * Return an associative array of breed name as the $key and all the image source url belongs to that breed as $value(which is in array format)
     * @return array
     */
    public function getCatImg($catBreeds)
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
    public function fillCatImg($catBreedArray, $catImgSrcArray)
    {
        $dbconnect = $this->dbConnect();
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
        $sql = $dbconnect->prepare('INSERT INTO `img` (img_src, breed_id) VALUES ' . $sqlString . ';');
        $sql->execute();
    }
}
# Make a new object and call the methods
$DBobject = new DB();
$breeds = $DBobject->getCatBreed();
$DBobject->fillCatBreedToDB($breeds);
$catImgSrcArray = $DBobject->getCatImg($breeds);
$DBobject->fillCatImg($breeds, $catImgSrcArray);
