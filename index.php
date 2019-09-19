<?php
require_once __DIR__ . '/vendor/autoload.php';

$db = new TopCat\Utilities\DB();
$dbConnection = $db->dbConnect();

// Prepare target strings
$dropdownBreeds = '';
$catshtml = '';

// Populate the dropdown with the list of breeds from the DB
$breedSql = $dbConnection->prepare('SELECT `breed` FROM `breed`');
$breedSql->execute();
$breeds = $breedSql->fetchAll();

for ($i = 0; $i < count($breeds); $i++) {
    $breed = $breeds[$i]['breed'];
    $id = $i + 1;
    $dropdownBreeds .= "<option value=\"$id\">$breed</option>";
}

// If the user has selected a breed, get and show the cats
if (isset($_GET['breed'])) {
    $catHydrator = new TopCat\Hydrators\CatHydrator($dbConnection);
    $cats = $catHydrator->createCatEntitiesArray((int)$_GET['breed']);
    foreach ($cats as $cat) {
        $catshtml .= '<div class="cat-image"><img src="' . $cat->getImage() . '" alt="A cat"></div>';
    }
}

if (isset($_POST['newFavourite']) && isset($_POST['breedID'])) {
    $favouriteSql = $dbConnection->prepare('UPDATE `breed` SET favourite_id = :newFavourite WHERE id= :breedID;');
    $favouriteSql->bindParam('newFavourite', $_POST['newFavourite'], PDO::PARAM_INT);
    $favouriteSql->bindParam('breedID', $_POST['breedID'], PDO::PARAM_INT);
    $favouriteSql->execute();
    $favouriteResponseMessage = 'Cat successfully favourited';
} else {
    $favouriteResponseMessage = 'Favourite POST not set';
}

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
                        <?php echo $dropdownBreeds ?>
                    </select>
                </div>
            </div>
            <input class="sub-btn" type="submit" value="Show me the cats!">
        </form>
    </div>
</div>
<div class="container">
    <div class="cat-pictures">
        <?php echo $catshtml; ?>
    </div>
</div>
<div class="footer"></div>
</body>
</html>