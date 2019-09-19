<?php
require_once __DIR__ . '/vendor/autoload.php';

$db = new TopCat\Utilities\DB();
$dbConnection = $db->dbConnect();
$catHydrator = new TopCat\Hydrators\CatHydrator($dbConnection);

// Populate the dropdown with the list of breeds from the DB
$breeds = $catHydrator->getBreeds();

$dropdownBreeds = '';
for ($i = 0; $i < count($breeds); $i++) {
    $breed = $breeds[$i]['breed'];
    $id = $i + 1;
    $dropdownBreeds .= "<option value=\"$id\">$breed</option>";
}

// If the user has selected a breed, get and show the cats
$catsHtml = '';
if (isset($_GET['breed'])) {
    $cats = $catHydrator->createCatEntitiesArray((int)$_GET['breed']);
    foreach ($cats as $cat) {
        $catsHtml .= '<div class="cat-image">
        <div class="favorite-icon-container">
        <form action="index.php" method="post">
        <input class="cat-id-input" name="breedID" value="' . $cat->getBreed() . '">
        <input class="cat-id-input" name="newFavourite" value="' . $cat->getID() . '">
        <img class="favorite-icon" src="';

        $breedWanted = $_GET['breed'] - 1;

        if($cat->getID() == $breeds[$breedWanted]['favourite_id']) {
            $catsHtml .= 'images/fav-icon-full.svg';
            } else { $catsHtml .= 'images/fav-icon-empty.svg';
        }

        $catsHtml .=  '" alt="">
        </form>
        </div>
        <img src="' . $cat->getImage() . '" alt="A cat">
        </div>';
    }
}

$favouriteResponseDisplay = '';

//Checks if a POST is set for newFavourite and breedID.
//Then updates row in Database setting the breed row to have that newFavourite ID.
if (isset($_POST['newFavourite']) && isset($_POST['breedID'])) {
    $favouriteSql = $dbConnection->prepare('UPDATE `breed` SET favourite_id = :newFavourite WHERE id= :breedID;');
    //newFavourite is the ID of the image of the favourite cat.
    $favouriteSql->bindParam('newFavourite', $_POST['newFavourite'], PDO::PARAM_INT);
    //breedID is the ID of the breed of cat.
    $favouriteSql->bindParam('breedID', $_POST['breedID'], PDO::PARAM_INT);
    $favouriteSql->execute();
    $favouriteResponseMessage = 'Cat successfully favourited';
    $favouriteResponseDisplay .= '<div class="favorite-response-message">' . $favouriteResponseMessage . '</div>';
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
    <script defer src="js/script.js"></script>
</head>
<body>
<div class="header">
    <div class="container">
        <h1>Top Cat</h1>
        <form action="index.php" method="get">
            <div class="form-group">
                <select name="breed" id="select-breed">
                    <option value="0">Please select your breed</option>
                    <?php echo $dropdownBreeds ?>
                </select>
            </div>
            <input class="submit-button" type="submit" value="Show me the cats!">
        </form>
    </div>
</div>
<div class="container cat-pictures">
    <?php echo $favouriteResponseDisplay; ?>
    <?php echo $catsHtml; ?>
</div>
</body>
</html>