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
        $catBreeds = $this->getCatBreed();
        foreach($catBreeds as $id=>$breed) {
            $sql = $dbconnect->prepare('INSERT INTO `breed` (breed) VALUES (\'' . $breed . '\');');
            $sql->execute();
        }
    }

    // Get img src from the Cat API
    public function getCatImg()
    {
        $catBreeds = $this->getCatBreed();
        $imgSrcArray = [];
        foreach ($catBreeds as $id=>$name) {
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
            //array_push($imgSrcArray, $breedImgs);   //Swap array_push for method that gives key of breed name
            $imgSrcArray[$name] = $breedImgs;
        }
        //var_dump($imgSrcArray);
        return $imgSrcArray;
    }

    // Fill img src to table
    public function fillCatImg()
    {
        $catImgSrcArray = $this->getCatImg();
        $dbconnect = $this->dbConnect();
        $catBreedArray = $this->getCatBreed();
        $catBreedIndexedArray = [];

        foreach($catBreedArray as $breed) {
            $catBreedIndexedArray[] = $breed;
        }

        var_dump($catBreedIndexedArray);
        echo '</br>';
        echo '</br>';

        $sqlArray = [];

        var_dump($sqlArray);
        echo '</br>';
        echo '</br>';
        for($breedIndex = 0; $breedIndex < count($catImgSrcArray); $breedIndex++) {
            foreach($catImgSrcArray[$catBreedIndexedArray[$breedIndex]] as $url) {
                $breedID = $breedIndex + 1;
                $sqlArray[] = "('$url', $breedID)";
            }
        }

        var_dump($sqlArray);
        echo '</br>';
        echo '</br>';

        $sqlString = implode(',', $sqlArray);

        echo $sqlString;
//        echo '</br>';
//        echo '</br>';

        $sql = $dbconnect->prepare('INSERT INTO `img` (img_src, breed_id) VALUES ' . $sqlString . ';');
        $sql->execute();
    }

}

$test = new DB();
$result = $test->fillCatImg();


