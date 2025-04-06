<?php 
if (!isset($_SESSION['id'])) {
  header("Location: index.php");
  exit();
}
include "component/category.html";
if (isset($_GET['productId'])) {
  $_SESSION['productId'] = $_GET['productId'];
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php
    $conn = mysqli_connect('localhost', 'root', '', 'keyboardshop');
    $productId = $_SESSION['productId'];
    $result = mysqli_query($conn, "SELECT * FROM product WHERE ProductID = '$productId'");
    $row = mysqli_fetch_assoc($result);
    echo $row['Name'];
    mysqli_close($conn)
  ?></title>
  <link rel="stylesheet" href="css/product.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css">
</head>
<body>
  <section>
    <div class="container pt-3">
    

      <div class="row gy-5">
        <div class="col col-md-6">
          <div class="slider-container">
            <div class="d-flex-column align-items-center justify-content-center">
              <?php 
                $conn = mysqli_connect('localhost', 'root', '', 'keyboardshop');
                $result = mysqli_query($conn, "SELECT * FROM Product WHERE ProductID = '$productId'");
                $product = mysqli_fetch_assoc($result);
                $result = mysqli_query($conn, "SELECT * FROM productvariant WHERE ProductID = '$productId'");
                $variants = [];
                while ($row = mysqli_fetch_assoc($result)) {
                  $variants[] = [
                    'color' => $row['Color'],
                    'image' => $row['Image'],
                    'stock' => $row['stock']
                  ];
                }
                echo "
                  <div class='main-image'>
                    <a id='mainImageLink' href='{$variants[0]['image']}' data-fancybox='gallery'>
                        <img id='displayedImage' src='{$variants[0]['image']}' alt='Main Image'>
                    </a>
                  </div>
                ";

                echo "<div class='thumbnail-container'>";
                foreach ($variants as $index => $variant) {
                  echo "<img class='thumbnail' src='".$variant['image']."' onclick='changeImage(\"".$variant['image']."\")' alt='Thumbnail ".$index."'>";
                }
                echo "</div>";
                mysqli_close($conn)
              ?>
            </div>
          </div>
        </div>
        <div class="col col-md-6 text-start">
          <?php 
            echo "<h1 class='product-name text-start' data-id='".$product["ProductID"]."'>".$product['Name']."</h1>";
            echo "<h2 class='text-start' style='color:red; margin-top: 20px;'>".number_format($product["Price"], 0, ',', '.')."đ</h2>";
          ?>
          <?php 
            $hasVariant = true;

            foreach ($variants as $variant) {
                if ($variant['color'] == 'Basic') { 
                    $hasVariant = false;
                    break;
                }
            }

            if ($hasVariant) {
                echo "<div style='font-size: 30px; margin-bottom: 20px;'>Variants: <span id='stockDisplay' style='font-size: 20px; margin-left: 10px;'></span></div>";
                echo "<div class='d-flex' style='gap: 10px;'>";
                $store = [];
                $firstInStock = null;

                foreach ($variants as $index => $variant) {
                    if (in_array($variant["color"], $store)) {
                        continue;
                    }
                    $store[] = $variant["color"];
                    
                    if ($variant['stock'] > 0 && $firstInStock === null) {
                        $firstInStock = $variant;
                    }

                    if ($variant['stock'] > 0) {
                        echo "<button class='variant-btn' data-image='".$variant['image']."' data-color='".$variant['color']."' data-stock='".$variant['stock']."' style='width:120px;";
                    } else {
                        echo "<button disabled class='out-stock variant-btn' data-image='".$variant['image']."' data-color='".$variant['color']."' data-stock='0' style='width:120px;";
                    }
                    echo "
                        padding: 8px 10px;
                        border: none;
                        border-radius: 8px;
                    '>".$variant["color"]."</button>";
                }
                echo "</div>";

                if ($firstInStock !== null) {
                    echo "<script>document.addEventListener('DOMContentLoaded', () => {
                        let firstBtn = document.querySelector('.variant-btn[data-color=\"{$firstInStock['color']}\"]');
                        firstBtn.classList.add('active');
                        document.getElementById('stockDisplay').innerHTML = 'Stock: {$firstInStock['stock']}';
                        changeImage('{$firstInStock['image']}');
                    });</script>";
                }
            }
            ?>
          <div class="d-flex align-items-center">
            <div style="font-size: 30px; margin-right:40px">Quantity: </div>
            <div class="d-flex align-items-center">
              <button class="minus-btn" tabindex="-1">-</button>
              <!-- <p class="quantity" style="font-size: 30px; margin:0; padding:0; margin-left: 30px; margin-right: 30px">1</p> -->
              <input class="quantity" type="number" style="font-size: 30px; margin:0; padding:0; margin-left: 30px; margin-right: 30px; width: 80px; border: none;" value="1" min="1">
              <button class="plus-btn" tabindex="-1">+</button>
            </div>
          </div>
          <div class="container pt-5">
            <div class="row text-center gy-3">
              <div class="col col-xxl-6">
                <button class="add-to-cart">ADD TO CART</button>
              </div>
              <div class="col col-xxl-6">
                 <button class="buy-now">BUY NOW</button>
              </div>
            </div>
          </div>
          
        </div>
      </div>
    </div>
  </section>

  <section class="container text-start mt-5">
    <div class="row gy-3">
      <div class="col col-md-8">
        <h2 class="text-center">
          <?php echo $product["Name"]?>
        </h2>
        <div>
          <div>Product Information</div>
          <?php 
            echo nl2br(str_replace("- ", "<br>-", $product["Description"]));
            echo "<br><br><br>";
            if ($product['ProductType'] == "Switch") {
              $parsedUrl = parse_url($product['Soundtest']);
              parse_str($parsedUrl['query'], $queryParams);
              $videoId = $queryParams['v'];
              echo "<iframe width='560' height='315' src='https://www.youtube.com/embed/".$videoId."' title='YouTube video player' frameborder='0' allow='accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share' referrerpolicy='strict-origin-when-cross-origin' allowfullscreen></iframe>";
            }
            
          ?>
        </div>
      </div>

      <div class="col col-md-4">
        <h3 class="mb-3">Relevant Products</h3>
        <?php 
          $conn = mysqli_connect('localhost', 'root', '', 'keyboardshop');
          $result = mysqli_query($conn, "SELECT *, 
            (SELECT pv.Image 
             FROM productvariant pv 
             WHERE pv.ProductID = p.ProductID 
             ORDER BY pv.Color ASC 
             LIMIT 1) AS image 
          FROM Product p 
          WHERE ProductType = '{$product["ProductType"]}' 
          AND ProductID <> {$product["ProductID"]} 
          ORDER BY RAND() 
          LIMIT 4");

          $rel_products = mysqli_fetch_all($result, MYSQLI_ASSOC);

          foreach ($rel_products as $rel_product) {
              echo "<div data-id='".$rel_product['ProductID']."' class='d-flex mb-3 rel-product-container' style='cursor:pointer; gap:15px; border-radius:10px; overflow: hidden; box-shadow: 5px 6px 6px rgba(0,0,0,0.4);'>
                      <div style='flex:0.5;'>
                        <img style='width: 120px; height: 120px; object-fit: cover;' src='".$rel_product['image']. "' alt='".$rel_product['image']."'>
                      </div>
                      <div style='flex:1;'>
                        <div class='product-title'>".$rel_product["Name"]."</div>
                        <div style='color: red;'>".number_format($rel_product["Price"], 0, ',', '.')."đ</div>
                      </div>
                    </div>";
          }
          mysqli_close($conn)
        ?>
        
      </div>
    </div>
    
  </section>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
  <script src="js/product.js"></script>
</body>
</html>