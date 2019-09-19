<?php
require_once __DIR__ . '/../../vendor/autoload.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

use TopCat\Utilities\DB;

$db = new DB();
$dbConnection = $db->dbConnect();

// get POSTed data
$data = json_decode(file_get_contents("php://input"));

// make sure this isn't empty
if (
  !empty($data->catID) &&
  !empty($data->breed)
) {
  $newFavouriteCat = (integer)$data->catID;
  $ofBreed = (integer)$data->breed;
  // TODO: put this in a try-catch like it should be
  $favouriteSql = $dbConnection->prepare("UPDATE `breed` SET `favourite_id` = :newFavourite WHERE `id`= :breedID;");
  $favouriteSql->bindParam(':newFavourite', $newFavouriteCat, PDO::PARAM_INT);
  $favouriteSql->bindParam(':breedID', $ofBreed, PDO::PARAM_INT);
  $favouriteSql->execute();
  // Response code 201 - you successfully added data
  http_response_code(201);
  echo json_encode(["message" => "Cat $data->catID successfully favourited for breed $data->breed"]);
} else {
  // Response code 400 - bad request
  http_response_code(400);
  echo json_encode(["message" => "Favouriting not successful"]);
}

