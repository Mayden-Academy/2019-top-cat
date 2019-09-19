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
        $catsHtml .= '<div class="cat-image"><img src="' . $cat->getImage() . '" alt="' . $breeds[$cat->getBreed() - 1]['breed'] . '"></div>';
    }
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
    <?php echo $catsHtml; ?>
</div>
</body>
</html>