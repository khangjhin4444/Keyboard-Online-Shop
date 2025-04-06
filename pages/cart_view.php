<?php 
  if (!isset($_SESSION['id'])) {
    header("Location: index.php");
    exit();
  }
  $id = $_SESSION['id'];
  include "component/category.html";
  include "models/update_cart_db.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cart</title>
  <link rel="stylesheet" href="css/cart_view.css">
</head>
<body>
  <div class="container text-start" style="border-bottom: 2px solid black;">
    <h2>Your Cart</h2>
  </div>
  <div class="container text-md-start pt-3 cart-container">
    <?php
      $conn = mysqli_connect('localhost', 'root', '', 'keyboardshop');
      $result = mysqli_query($conn, "SELECT * FROM cartproduct WHERE UserID = '{$id}'");
      if (mysqli_num_rows($result) == 0) {
        echo "<div>No items in your cart!</div>";
      } else {
        while ($row = mysqli_fetch_assoc($result)) {
          $query_1 = mysqli_query($conn, "SELECT * FROM product WHERE ProductID = '".$row['ProductID']."'");
          $product = mysqli_fetch_assoc($query_1);

          $query_2 = mysqli_query($conn, "SELECT * FROM productvariant WHERE ProductID = '".$row['ProductID']."' AND Color = '".$row['Color']."'");
          $variant = mysqli_fetch_assoc($query_2);
          if ($variant['stock'] == 0) {
            updateCartProduct($row['UserID'], $product['ProductID'], $variant['Color'], 0);
          } else {
            if ($row['Quantity'] > $variant['stock']) {
              updateCartProduct($row['UserID'], $product['ProductID'], $variant['Color'], $variant['stock']);
            }
            echo "<div class='row pb-4 product-container' data-id='".$product['ProductID']."' data-color='".$variant['Color']."'>
                  <div class='col-sm-6 row'>
                    <div class='col-lg-6'>
                      <img class='product-img' src='".$variant['Image']."' alt='".$product['Name']."'>
                    </div>
                    <div class='col-lg-6'>
                      <h4>".$product['Name']."</h4>
                      <h5>".$variant['Color']."</h5>
                      <button class='btn btn-outline-danger' data-id='".$product['ProductID']."' data-color='".$variant['Color']."'>
                        Delete
                      </button>
                    </div>
                  </div>
                  <div class='col-sm-6 row align-items-center py-1'>
                    <div class='col-md-12 align-items-center py-1'>
                      <h5 class='price' style='margin:0; padding:0;' data-id='".$product['ProductID']."' data-color='".$variant['Color']."' >Price: ".number_format($product["Price"], 0, ',', '.')."đ</h5>
                    </div>
                    <div class='col-md-6 col-sm-12 d-flex align-items-center justify-content-center py-1'>
                      <h5 style='margin:0; padding:0; margin-right:10px;'>Quantity: </h5>
                      <button data-id='".$product['ProductID']."' data-color='".$variant['Color']."' class='minus-btn' tabindex='-1'>-</button>
                      <p class='quantity' data-id='".$product['ProductID']."' data-color='".$variant['Color']."' data-price='".$product['Price']."' style='font-size: 20px; margin:0; padding:0; margin-left: 20px; margin-right: 20px'>".$row['Quantity']."</p>
                      <button data-id='".$product['ProductID']."' data-color='".$variant['Color']."' class='plus-btn' tabindex='-1'>+</button>
                    
                    </div>
                    <div class='col-md-6 col-sm-12 col-sm-6 align-items-center'>
                      <h5 data-id='".$product['ProductID']."' data-color='".$variant['Color']."' class='total' style='margin:0; padding:0;'>".number_format($row['Quantity'] * $product['Price'], 0, ',', '.')."đ</h5>
                    </div>
                  </div>
                </div>";
          }
        }
        echo "
          <div class='payment' style='position: fixed; bottom: 55px; right: 20px; background-color: white; padding: 10px 12px; border-radius: 20px;'>
            <div class='container d-flex justify-content-end'>
              <h4 style='padding-right: 30px;'>Total: </h4>
              <h4 class='total-price'></h4>
            </div>
            <div class='container d-flex justify-content-end'>
              <button class='btn btn-success pay-btn' style='font-size: 20px; font-weight: bold; margin: 10px;'>BILL PAYMENT</button>
            </div>
          </div>
        ";
      }
    ?>
    
    
  </div>
  <script src="js/cart_view.js"></script>
</body>
</html>