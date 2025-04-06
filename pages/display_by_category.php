<?php
  if (isset($_GET['ProductType'])) {
    $productType = $_GET['ProductType'];
  }
  if (isset($_GET['size'])) {
    $size = $_GET['size'];
  }
  if (isset($_GET['type'])) {
    $type = $_GET['type'];
  }
  if (isset($_GET['profile'])) {
    $profile = $_GET['profile'];
  }
  include "component/category.html";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>
    <?php 
      if ($productType == 'KeyboardKit') {
        $title = "Keyboard Kit ".$size;
        $id = 1;
        $productList = "product-list-KeyboardKit";
        $sub = $size;
        echo $title;
      }
      if ($productType == 'Keycap') {
        $title = "Keycap Profile ".$profile;
        $id = 2;
        $productList = "product-list-Keycap";
        $sub = $profile;
        echo $title;
      }
      if ($productType == 'Prebuild') {
        $title = "PreBuild ".$size;
        $id = 3;
        $productList = "product-list-Prebuild";
        $sub = $size;
        echo $title;
      }
      if ($productType == 'Switch') {
        $title = "Switch ".$type;
        $id = 4;
        $productList = "product-list-Switch";
        $sub = $type;
        echo $title;
      }
    ?>
  </title>
  <link rel="stylesheet" href="css/display_by_category.css">
</head>
<body>
  <div class="container p-4">
    <h1 class="lead py-2" style="font-size: 20px; font-weight: bolder;"><?php echo $title?></h1>
    <div class="d-lg-flex align-items-center py-2 sort-section">
      <p class="m-0 px-5 py-2">Sort by:</p>
      <p class="m-0 px-3 py-1">Name</p>
      <div class='d-flex justify-content-center py-1'>
        <select id="<?php echo $id ?>" data-sub="<?php echo $sub ?>" class="form-select sort-name" style="width: 200px;">
          <option value="default" selected>Default</option>
          <option value="asc">A-Z</option>
          <option value="desc">Z-A</option>
        </select>
      </div>
      

      <p class="m-0 px-3 py-1">Price</p>
      <div class='d-flex justify-content-center py-1'>
        <select id="<?php echo $id ?>" data-sub="<?php echo $sub ?>" class="form-select sort-price" style="width: 200px;">
          <option value="default" selected>Default</option>
          <option value="asc">Low to high</option>
          <option value="desc">High to low</option>
        </select>
      </div>
    </div>
  </div>

  <div class="container">
    <div>
      <div id="<?php echo $productList ?>" class="row gy-4 align-items-center justify-content-around">
        <?php
          $conn = mysqli_connect("localhost", "root", "", "keyboardshop");
          if (!$conn) {
              die("Connection failed: " . mysqli_connect_error());
          }
      
          // Truy vấn lấy 8 sản phẩm đầu tiên của loại $type
          if ($productType == 'KeyboardKit' || $productType == 'Prebuild') {
            $sql = "SELECT p.ProductId AS id,
                      p.Name AS name, 
                      p.Price AS price, 
                      (SELECT pv.Image 
                      FROM productvariant pv 
                      WHERE pv.ProductID = p.ProductID 
                      ORDER BY pv.Color ASC 
                      LIMIT 1) AS image
                  FROM product p
                  WHERE p.ProductType = '$productType' AND p.Size = '$size' 
                  LIMIT 8;";
          }
          if ($productType == 'Keycap') {
            $sql = "SELECT p.ProductId AS id,
                      p.Name AS name, 
                      p.Price AS price, 
                      (SELECT pv.Image 
                      FROM productvariant pv 
                      WHERE pv.ProductID = p.ProductID 
                      ORDER BY pv.Color ASC 
                      LIMIT 1) AS image
                  FROM product p
                  WHERE p.ProductType = '$productType' AND p.Profile = '$profile'
                  LIMIT 8;";
          }
          if ($productType == 'Switch') {
            $sql = "SELECT p.ProductId AS id,
                      p.Name AS name, 
                      p.Price AS price, 
                      (SELECT pv.Image 
                      FROM productvariant pv 
                      WHERE pv.ProductID = p.ProductID 
                      ORDER BY pv.Color ASC 
                      LIMIT 1) AS image
                  FROM product p
                  WHERE p.ProductType = '$productType' AND p.Type = '$type'
                  LIMIT 8;";
          }
          // $sql = "SELECT p.ProductId AS id,
          //             p.Name AS name, 
          //             p.Price AS price, 
          //             (SELECT pv.Image 
          //             FROM productvariant pv 
          //             WHERE pv.ProductID = p.ProductID 
          //             ORDER BY pv.Color ASC 
          //             LIMIT 1) AS image
          //         FROM product p
          //         WHERE p.ProductType = '$type'
          //         LIMIT 8;";
          
          $result = mysqli_query($conn, $sql);
          
          while ($row = mysqli_fetch_assoc($result)) {
            if ($_SESSION['login'] == 'guest') {
              echo '<div class="col col-12 col-xxl-3 col-xl-4 col-md-6 text-center">';
              echo '<div class="card" style="width: 100%; height: 100%;">';
              echo "<a href='authentication.php'><img src='{$row["image"]}' class='card-img-top' style='width: 100%; height: 300px !important; object-fit:cover' alt='{$row["name"]}'></a>";
              echo '<div class="card-body" style="height: 150px;">';
              echo '<h5 class="card-title" style="font-size: 16px; height: 30px">' . $row["name"] . '</h5>';
              echo '<p class="card-text">Price: ' . number_format($row["price"], 0, ',', '.') . 'đ</p>';
              echo '<a href="authentication.php" class="btn btn-primary">VIEW MORE</a>';
              echo '</div></div></div>';
            } else {
                echo '<div class="col col-12 col-xxl-3 col-xl-4 col-md-6 text-center">';
                echo '<div class="card" style="width: 100%; height: 100%;">';
                echo "<a href='?page=product.php&productId={$row['id']}'><img src='{$row["image"]}' class='card-img-top' style='width: 100%; height: 300px !important; object-fit:cover' alt='{$row["name"]}'></a>";
                echo '<div class="card-body" style="height: 150px;">';
                echo '<h5 class="card-title" style="font-size: 16px; height: 30px">' . $row["name"] . '</h5>';
                echo '<p class="card-text">Price: ' . number_format($row["price"], 0, ',', '.') . 'đ</p>';
                echo "<a href='?page=product.php&productId={$row['id']}' class='btn btn-primary'>VIEW MORE</a>";
                echo '</div></div></div>';
            }
          }
      
          // Kiểm tra xem có nhiều hơn 8 sản phẩm không
          if ($productType == 'KeyboardKit' || $productType == 'Prebuild') {
            $check_sql = "SELECT COUNT(*) AS total FROM Product WHERE ProductType = '$productType' AND Size = '$size'";
          }
          if ($productType == 'Keycap') {
            $check_sql = "SELECT COUNT(*) AS total FROM Product WHERE ProductType = '$productType' AND Profile = '$profile'";
          }
          if ($productType == 'Switch') {
            $check_sql = "SELECT COUNT(*) AS total FROM Product WHERE ProductType = '$productType' AND Type = '$type'";
          }
          $check_result = mysqli_query($conn, $check_sql);
          $check_row = mysqli_fetch_assoc($check_result);
          $total_products = $check_row['total'];
      
          if ($total_products == 0) {
            echo '<script>
                      document.addEventListener("DOMContentLoaded", function() {
                          document.querySelector(".sort-section").classList.add("justify-content-center");
                          document.querySelector(".sort-section").innerHTML = "No product to show.";
                          document.querySelector(".sort-section").style.fontSize = "30px";
                      });
                    </script>';
          }

          if ($total_products == 1) {
            echo '<script>
                      document.addEventListener("DOMContentLoaded", function() {
                          document.querySelector(".sort-section").innerHTML = "";
                      });
                    </script>';
          }

          if ($total_products <= 8) {
              echo '<script>
                      document.addEventListener("DOMContentLoaded", function() {
                          document.querySelectorAll(".show-more-btn").forEach(btn => {
                              if (btn.id === "'.$id.'") {
                                  btn.style.display = "none";
                              }
                          });
                      });
                    </script>';
          }
      
          mysqli_close($conn);
        ?>
      </div>
      <div id="<?php echo $id ?>" class="text-center mt-3 div-btn">
        <button id="<?php echo $id ?>" data-sub="<?php echo $sub ?>" class="btn btn-secondary show-more-btn">Show More</button>
      </div>
    </div>
  </div>
  

  <!-- <script src="js/home.js"></script> -->
  <script src="js/display_by_category.js"></script>
</body>
</html>