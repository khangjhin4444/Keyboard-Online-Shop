<?php
include("component/category.html");
// include("database.php");
include("models/functions.php");
// mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JK Keyboard</title>

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
      <h1 class="lead py-2" style="font-size: 20px; font-weight: bolder;">Keyboard Kit</h1>
      <div class="d-lg-flex align-items-center  py-2">
        <p class="m-0 px-5 py-2">Sort by:</p>
        <p class="m-0 px-3 py-1">Name</p>
        <div class='d-flex justify-content-center py-1'>
          <select id="1" class="form-select sort-name" style="width: 200px;">
            <option value="default" selected>Default</option>
            <option value="asc">A-Z</option>
            <option value="desc">Z-A</option>
          </select>
        </div>
        

        <p class="m-0 px-3 py-1">Price</p>
        <div class='d-flex justify-content-center py-1'>
          <select id="1" class="form-select sort-price" style="width: 200px;">
            <option value="default" selected>Default</option>
            <option value="asc">Low to high</option>
            <option value="desc">High to low</option>
          </select>
        </div>
        
      </div>
    </div>
    <div class="container">
      <div>
        <div id="product-list-KeyboardKit" class="row gy-4 align-items-center justify-content-around">
          <?php
            renderCard("KeyboardKit", 1);
          ?>
        </div>
        <div id="1" class="text-center mt-3 div-btn">
          <button id="1" class="btn btn-secondary show-more-btn">Show More</button>
        </div>
      </div>
    </div>


    <div class="container p-4">
      <h1 class="lead py-2" style="font-size: 20px; font-weight: bolder;">Switch</h1>
      <div class="d-lg-flex align-items-center  py-2">
        <p class="m-0 px-5 py-2">Sort by:</p>
        <p class="m-0 px-3 py-1">Name</p>
        <div class='d-flex justify-content-center py-1'>
          <select id="4" class="form-select sort-name" style="width: 200px;">
            <option value="default" selected>Default</option>
            <option value="asc">A-Z</option>
            <option value="desc">Z-A</option>
          </select>
        </div>
        

        <p class="m-0 px-3 py-1">Price</p>
        <div class='d-flex justify-content-center py-1'>
          <select id="4" class="form-select sort-price" style="width: 200px;">
            <option value="default" selected>Default</option>
            <option value="asc">Low to high</option>
            <option value="desc">High to low</option>
          </select>
        </div>
        
      </div>
    </div>
    <div class="container">
      <div>
        <div id="product-list-Switch" class="row gy-4 align-items-center justify-content-around">
          <?php
            renderCard("Switch", 4);
          ?>
        </div>
        <div id="4" class="text-center mt-3 div-btn">
          <button id="4" class="btn btn-secondary show-more-btn">Show More</button>
        </div>
      </div>
    </div>


    <div class="container p-4">
      <h1 class="lead py-2" style="font-size: 20px; font-weight: bolder;">Keycap</h1>
      <div class="d-lg-flex align-items-center py-2">
        <p class="m-0 px-5 py-2">Sort by:</p>
        <p class="m-0 px-3 py-1">Name</p>
        <div class='d-flex justify-content-center py-3'>
          <select id="2" class="form-select sort-name" style="width: 200px;">
            <option value="default" selected>Default</option>
            <option value="asc">A-Z</option>
            <option value="desc">Z-A</option>
          </select>
        </div>
        

        <p class="m-0 px-3 py-1">Price</p>
        <div class='d-flex justify-content-center py-3'>
          <select id="2" class="form-select sort-price" style="width: 200px;">
            <option value="default" selected>Default</option>
            <option value="asc">Low to high</option>
            <option value="desc">High to low</option>
          </select>
        </div>
        
      </div>
    </div>
    <div class="container">
      <div>
        <div id="product-list-Keycap" class="row gy-4 align-items-center justify-content-around">
          <?php
            renderCard("Keycap", 2);
          ?>
        </div>
        <div id="2" class="text-center mt-3 div-btn">
          <button id="2" class="btn btn-secondary show-more-btn">Show More</button>
        </div>
      </div>
    </div>


    <div class="container p-4">
      <h1 class="lead py-2" style="font-size: 20px; font-weight: bolder;">PreBuild</h1>
      <div class="d-lg-flex align-items-center py-2">
        <p class="m-0 px-5 py-2">Sort by:</p>
        <p class="m-0 px-3 py-1">Name</p>
        <div class='d-flex justify-content-center py-3'>
          <select id="3" class="form-select sort-name" style="width: 200px;">
            <option value="default" selected>Default</option>
            <option value="asc">A-Z</option>
            <option value="desc">Z-A</option>
          </select>
        </div>
        

        <p class="m-0 px-3 py-1">Price</p>
        <div class='d-flex justify-content-center py-3'>
          <select id="3" class="form-select sort-price" style="width: 200px;">
            <option value="default" selected>Default</option>
            <option value="asc">Low to high</option>
            <option value="desc">High to low</option>
          </select>
        </div>
      </div>
    </div>
    <div class="container">
      <div>
        <div id="product-list-Prebuild" class="row gy-4 align-items-center justify-content-around">
          <?php
            renderCard("Prebuild", 3);
          ?>
        </div>
        <div id="3" class="text-center mt-3 div-btn">
          <button id="3" class="btn btn-secondary show-more-btn">Show More</button>
        </div>
      </div>
    </div>

    <script src="./js/home.js"></script>

  </body>
</html>

