<?php

//function drawCats(array $cats) :string {
//    $stringyCats = '';
//    foreach($cats as $cat) {
//        $stringyCats .= '<div class="cat-image"><img src="' . $cat->image . '" alt="A cat"></div>';
//    }
//    return $stringyCats;
//}
//
//$catshtml = drawCats($cats);

if (isset($_GET['breed'])) {
    //get array of cats from cat hydrator
    // draw cats
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
                <?php ?>
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