<?php


class DB
{
    private $serverdb = 'mysql:host=192.168.20.20; dbname=cat-test';
    private $username = 'root';
    private $password = '';

    // Create connection

    /**
     * @return PDO
     */
    public function dbConnect()
    {
        $dbconnect = new PDO($this->serverdb, $this->username, $this->password);
        $dbconnect->setAttribute(
            PDO::ATTR_DEFAULT_FETCH_MODE,
            PDO::FETCH_ASSOC);
        return $dbconnect;
    }

    /**
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

    public function fillCatBreedToDB()
    {
        $dbconnect = $this->dbConnect();
        $catBreedName = $this->getCatBreed()[1];
        foreach($catBreedName as $breed) {
            $sql = $dbconnect->prepare('INSERT INTO `breed` (breed) VALUES (\'' . $breed . '\');');
            $sql->execute();
        }
    }

    // Get img src from the Cat API
    public function getCatImg()
    {
        $breedId = $this->getCatBreed()[0];
        $catImgUrl = [];
        foreach ($breedId as $id) {
            $catImgApiUrl = 'https://api.thecatapi.com/v1/images/search?breed_ids=' . $id . '&limit=21';
            array_push($catImgUrl, $catImgApiUrl);
        }

        $imgSrcArray = [];
        foreach ($catImgUrl as $apiUrl) {
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $apiUrl,
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

            foreach($responseArray as $item) {
                array_push($imgSrcArray, $item["url"]);
            }
        }
        return $imgSrcArray;
    }
}

$test = new DB();
$result = $test->getCatBreed();
var_dump($result);
