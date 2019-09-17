<?php

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
        <form action="post">
          <div class="form-group">
            <label>Select your breed:</label>
            <select name="breed" id="select-breed">
              <option value="">Please select:</option>
              <?php ?>
            </select>
          </div>
        </div>
      </form>
      </div>
      <div class="container">
        <div class="cat-pictures">
          <?php ?>
          <div class="cat-image">
            <img src="cat-pic-placeholder.jpg" alt="" srcset="">
          </div>
          <div class="cat-image">
            <img src="cat-pic-placeholder.jpg" alt="" srcset="">
          </div>
          <div class="cat-image">
            <img src="cat-pic-placeholder.jpg" alt="" srcset="">
          </div>
          <div class="cat-image">
            <img src="cat-pic-placeholder.jpg" alt="" srcset="">
          </div>
        </div>
      </div>
    </div>
    <div class="footer">

    </div>
  </body>
</html>