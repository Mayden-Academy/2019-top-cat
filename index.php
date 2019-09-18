<?php
require_once 'utilities/DB.php';

$dbConnection = new DB();

$db = $dbConnection->getPDO();
$breeds = [];
$breedSql = $db->prepare('SELECT `breed` FROM `breed`');
$breedSql->execute();
$breeds = $breedSql->fetchAll();

/***
 * Iterates through all breeds and populates
 * the dropdown options
 *
 * @param $breeds
 * @return string
 */

function populateDropdown($breeds)
{
    $stringyBreeds = '';

    for ($i = 0; $i < count($breeds); $i++) {
        $breed = $breeds[$i]['breed'];
        $stringyBreeds .= "<option>$breed</option>";
    }
    return $stringyBreeds;
}

/***
 * Iterates through cat images and displays them on the page
 *
 * @param array $cats
 * @return string
 */

function drawCats(array $cats): string
{
    $stringyCats = '';
    foreach ($cats as $cat) {
        $stringyCats .= '<div class="cat-image"><img src="' . $cat->image . '" alt="A cat"></div>';
    }
    return $stringyCats;
}

$dropdownBreeds = populateDropdown($breeds);

$catshtml = drawCats($cats);


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
        <form action="get">
            <div class="form-group">
                <label>Select your breed:</label>
                <div class="selector">
                    <select name="breed" id="select-breed">
                        <option value="0">Please select:</option>
                        <?php
                        echo $dropdownBreeds
                        ?>
                    </select>
                </div>
            </div>
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