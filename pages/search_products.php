<?php 
  include("models/functions.php");
  include("component/category.html");
  $conn = mysqli_connect("localhost", "root", "", "keyboardshop");
  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }
  $keyword = isset($_GET['keyword']) ? mysqli_real_escape_string($conn, $_GET['keyword']) : '';
  // echo $keyword;
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
      /* @media (max-width: 993px) {
        .card {
          width: 50%;
          height: 50%;
        }
      } */
    </style>
  </head>
  <body>


    <div class="container p-4">
      <h1 class="lead py-3" style="font-size: 20px; font-weight: bolder;">Search Result</h1>
    </div>
    <div class="container display">
      <div>
        <div id="product-list-KeyboardKit" class="row gy-4 align-items-center justify-content-around">
          <?php
            renderSearch("KeyboardKit", $keyword);
            renderSearch("Keycap", $keyword);
            renderSearch("Switch", $keyword);
            renderSearch("Prebuild", $keyword);
          ?>
        </div>
        <!-- <div id="1" class="text-center mt-3 div-btn">
          <button id="1" class="btn btn-secondary show-more-btn">Show More</button>
        </div> -->
      </div>
    </div>

    <script src="./js/search_products.js"></script>

  </body>
</html>

