<?php
require_once __DIR__ . '/vendor/autoload.php';

use TopCat\Hydrators\CatHydrator;

$db  = new \PDO("mysql:host=192.168.20.20; dbname=cat-test", 'root', '');
$catHydrator = new CatHydrator($db);

$cats = $catHydrator->createCatEntitiesArray(1);

echo '<br>';
echo '<br>';
echo $cats[0]->getID;
echo $cats[0]->getImage;
echo $cats[0]->getBreed;
echo $cats[0]->img_src;
echo $cats[0]->breed_id;
echo '<br>';
echo '<br>';
var_export($cats[0]);
echo '<br>';
echo '<br>';

// function drawCats(array $cats) :string {
//     $stringyCats = '';
//     foreach($cats as $cat) {
//         $stringyCats .= '<div class="cat-image"><img src="' . $cat->image . '" alt="A cat"></div>';
//     }
//     return $stringyCats;
// }

// $catshtml = drawCats($cats);

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
                <?php ?>
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