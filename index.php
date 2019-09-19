<?php

require_once __DIR__ . '/vendor/autoload.php';

use TopCat\Hydrators\CatHydrator;
use TopCat\Utilities\DB;

$db = new TopCat\Utilities\DB();
$dbconnection = $db->dbConnect();

$breeds = [];
$breedSql = $dbconnection->prepare('SELECT `breed` FROM `breed`');
$breedSql->execute();
$breeds = $breedSql->fetchAll();

$catHydrator = new TopCat\Hydrators\CatHydrator($dbconnection);

if (isset($_GET['breed'])) {
    $cats = $catHydrator->createCatEntitiesArray((int)$_GET['breed']);
    $catshtml = drawCats($cats);
}

/***
 * Iterates through all breeds and populates
 * the dropdown options
 *
 * @param $breeds
 * @return string
 */
function populateDropdown(array $breeds): string
{
    $stringyBreeds = '';

    for ($i = 0; $i < count($breeds); $i++) {
        $breed = $breeds[$i]['breed'];
        $id = $i + 1;
        $stringyBreeds .= "<option value=\"$id\">$breed</option>";
    }
    return $stringyBreeds;
}

/***
 * Iterates through cat images and displays them on the page
 *
 * @param array $cats
 * @return string
 */
function drawCats(array $cats) :string {
      $stringyCats = '';
    foreach ($cats as $cat) {
        $stringyCats .= '<div class="cat-image"><img src="' . $cat->getImage() . '" alt="A cat"></div>';
    }
    return $stringyCats;
}

$dropdownBreeds = populateDropdown($breeds);


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Top Cat</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="header">
    <div class="container">
        <h1>Top Cat</h1>
        <form action="index.php" method="get">
          <div class="form-group">
            <div class="selector">
              <select name="breed" id="select-breed">
                <option value="0">Please select your breed</option>
                <?php
                    echo $dropdownBreeds
                ?>
              </select>
            </div>
          </div>
            <input class="sub-btn" type="submit" value="Show me the cats!">
        </form>
    </div>
</div>
<div class="container">
    <div class="cat-pictures">
        <?php
        echo $catshtml;
        ?>
    </div>
</div>
<div class="footer">

</div>
</body>
</html>