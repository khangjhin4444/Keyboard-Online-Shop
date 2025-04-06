<?php 
  session_set_cookie_params([
    'httponly' => true,  // Ngăn JavaScript truy cập session cookie
    'secure' => true,    // Chỉ gửi cookie qua HTTPS (chỉ bật khi dùng HTTPS)
    'samesite' => 'Strict' // Ngăn CSRF attack
  ]);
  session_start();
  if ($_SESSION['login'] != 'admin') {
    header('Location: index.php');

  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
  <style>
    body {
      padding-bottom: 30px;
    }
  </style>
</head>
<body>
  <button class='btn btn-primary log-out-btn' style="position: fixed; top: 30px; right: 30px;">Log Out</button>
  <div class="container text-center pt-5">
    <h2>Add new product</h2>
    <div class='pt-3 d-flex justify-content-center'>
      <div class="form-floating mb-3" style="width: 500px;">
        <input type="name" class="form-control" id="floatingName" placeholder="name">
        <label for="floatingName">Name</label>
      </div>
    </div>
    <button class='btn btn-success continue-btn'>Continue</button>
    <div class="row py-3 product-option">
      <!-- <div class="col-12 col-md-3 pb-3">
        <label for="ProductType">Product Type</label>
        <select class="form-select ProductType">
          <option selected value="KeyboardKit">Keyboard Kit</option>
          <option value="Prebuild">PreBuild</option>
          <option value="Keycap">Keycap</option>
          <option value="Switch">Switch</option>
        </select>
        </div>
        <div class="col-12 col-md-3 pb-3">
          <label for="Size">Keyboard Size</label>
          <select class="form-select Size">
            <option selected value="Full Size">Full Size</option>
            <option value="75%">75% or less</option>
            <option value="TKL">TKL</option>
            <option value="Alice">Alice</option>
          </select>
        </div>
        <div class="col-12 col-md-3 pb-3">
          <label for="Profile">Profile Keycap</label>
          <select class="form-select Profile" disabled>
            <option selected value="Cherry">Cherry</option>
            <option value="MDA">MDA</option>
            <option value="SA">SA</option>
            <option value="Artisan">Artisan</option>
          </select>
        </div>
        <div class="col-12 col-md-3 pb-3">
          <label for="Type">Switch Type</label>
          <select class="form-select Type" disabled>
            <option selected value="Linear">Linear</option>
            <option value="Tactile">Tactile</option>
            <option value="Clicky">Clicky</option>
            <option value="Silent">Silent</option>
          </select>
        </div>
        <div class="form-floating p-1 mb-3 pb-3">
          <input type="url" class="form-control urlInput" id="floatingURL" placeholder="url" disabled>
          <label for="floatingURL">Soundtest URL</label>
        </div>

        <div class="form-floating p-2 mb-3" style="width: 500px;">
          <input type="text" class="form-control" id="floatingPrice" placeholder="price">
          <label for="floatingPrice">Price</label>
        </div>

        <div class="form-floating p-1">
          <textarea class="form-control" placeholder="Description" id="floatingTextarea2" style="height: 100px"></textarea>
          <label for="floatingTextarea2">Description</label>
        </div>

        <h3 class="text-start pb-2">Variants: </h3>
        <div class="variant-container">
          <div class="row align-items-center variant-row">
            <div class="col-12 col-md-3 pb-2">
              <div class="form-floating mb-3">
                <input type="text" class="form-control" id="floatingColor" placeholder="Basic">
                <label for="floatingColor">Color</label>
              </div>
            </div>
            <div class="col-12 col-md-3 pb-2">
              <div class="form-floating mb-3">
                <input type="text" class="form-control" id="floatingStock" placeholder="0">
                <label for="floatingStock">Stock</label>
              </div>
            </div>
            <div class="col-12 col-md-6 pb-2">
              <div class="mb-3">
                <input class="form-control form-control-lg" type="file" id="formFile" accept="image/*">
              </div>
            </div>
          </div>
        </div>
        
        <div class="d-flex align-items-start">
          <button class='btn btn-success' style="width: 40px; margin-right: 20px; font-size: 20px; padding: 3px 3px; height: 40px;">+</button>
          <button class='btn btn-danger' style="width: 40px; margin-right: 20px; font-size: 20px; padding: 3px 3px; height: 40px;">-</button>
          <button class='btn btn-primary ms-auto' style=" font-size: 20px; padding: 3px 10px; height: 40px;">ADD TO DATABASE</button>
        </div>
      
      </div> -->
  </div>

  <div class="container pt-4">
    <h2>Update Product</h2>
    <div class='pt-3 d-flex justify-content-center'>
      <div class="form-floating mb-3" style="width: 500px;">
        <input type="name" class="form-control" id="floatingSearchName" placeholder="name">
        <label for="floatingSearchName">Search by Name</label>
      </div>
    </div>
    <button class='btn btn-warning continue-search-btn'>Continue</button>
    <div class='pt-3'>
      <div class="row search-container">

      </div>
    </div>
    <div class="pt-2">
      <div class="row product-information">
        <!-- <div class="col-12 col-xl-6 mt-2">
          <div class="form-floating mb-3" style="width: 500px;">
            <input type="name" class="form-control" id="floatingChangeName" placeholder="name">
            <label for="floatingChangeName">Name</label>
          </div>
          <div class="form-floating" style="width: 500px;">
            <input type="name" class="form-control" id="floatingChangePrice" placeholder="name">
            <label for="floatingChangePrice">Price</label>
          </div>
        </div>

        <div class="col-12 col-xl-6 mt-2">
          <div class="form-floating" style="height: 100%; width: 100%;">
            <textarea class="form-control" placeholder="Description" id="floatingChangeTextarea" style="height: 100%; width: 100%;"></textarea>
            <label for="floatingChangeTextarea">Description</label>
          </div>
        </div> -->
      </div>
       <div class="row pt-3 product-change-option">
      <!--  <div class="col-12 col-md-3 pb-3">
          <label for="ProductType">Product Type</label>
          <select class="form-select ProductType">
            <option selected value="KeyboardKit">Keyboard Kit</option>
            <option value="Prebuild">PreBuild</option>
            <option value="Keycap">Keycap</option>
            <option value="Switch">Switch</option>
          </select>
        </div>
        <div class="col-12 col-md-3 pb-3">
          <label for="Size">Keyboard Size</label>
          <select class="form-select Size">
            <option selected value="Full Size">Full Size</option>
            <option value="75%">75% or less</option>
            <option value="TKL">TKL</option>
            <option value="Alice">Alice</option>
          </select>
        </div>
        <div class="col-12 col-md-3 pb-3">
          <label for="Profile">Profile Keycap</label>
          <select class="form-select Profile" disabled>
            <option selected value="Cherry">Cherry</option>
            <option value="MDA">MDA</option>
            <option value="SA">SA</option>
            <option value="Artisan">Artisan</option>
          </select>
        </div>
        <div class="col-12 col-md-3 pb-3">
          <label for="Type">Switch Type</label>
          <select class="form-select Type" disabled>
            <option selected value="Linear">Linear</option>
            <option value="Tactile">Tactile</option>
            <option value="Clicky">Clicky</option>
            <option value="Silent">Silent</option>
          </select>
        </div>
        <div class="form-floating p-1 mb-3 pb-3">
          <input type="url" class="form-control urlInput" id="floatingURL" placeholder="url" disabled>
          <label for="floatingURL">Soundtest URL</label>
        </div>-->
      </div> 

      <div class="row pt-3 variant-section" style="display: none;">
        <h3 class="text-start pb-2">Variants: </h3>
        <div class="variant-change-container">
          <!-- <div class="row align-items-center variant-change-row">
            <div class="col-12 col-md-3 pb-2">
              <div class="form-floating mb-3">
                <input type="text" class="form-control" id="floatingChangeColor" placeholder="Basic">
                <label for="floatingChangeColor">Color</label>
              </div>
            </div>
            <div class="col-12 col-md-3 pb-2">
              <div class="form-floating mb-3">
                <input type="text" class="form-control" id="floatingChangeStock" placeholder="0">
                <label for="floatingChangeStock">Stock</label>
              </div>
            </div>
            <div class="col-12 col-md-6 pb-2">
              <div class="mb-3">
                <input class="form-control form-control-lg" type="file" id="formChangeFile" accept="image/*">
              </div>
            </div>
          </div> -->
        </div>

        <div class='save-section'>
          <h4 class="p-2">If you want to delete a variant, set its stock to <span style="color: red;">0</span>, if you want to delete the whole product, click <span style="color: red;">DELETE</span></h4>
          <div class="d-flex align-items-start">
          <button class='btn btn-outline-danger delete-btn' style="font-weight: bold; font-size: 20px; padding: 3px 10px; height: 40px;">DELETE</button>
            <button class='btn btn-primary ms-auto save-btn' style=" font-size: 20px; padding: 3px 10px; height: 40px;">SAVE TO DATABASE</button>
          </div>
        </div>
      </div>
    </div>



    <div class="container text-start mb-3 mt-3" >
      <h2>Pending Orders</h2>
    </div>
    <div class='container order-container'>
      <?php
        $conn = mysqli_connect('localhost', 'root', '', 'keyboardshop');
        $result = mysqli_query($conn, "SELECT * FROM orders WHERE Status = 'Pending' ORDER BY Date DESC, Time DESC");
        if (mysqli_num_rows($result) == 0) {
          echo "<div style='font-size: 30px; font-weight: bold;'>No pending order!</div>";
        } else {
          while ($row = mysqli_fetch_assoc($result)) {
            $orderId = $row['OrderID'];
            $orderDate = $row['Date'];
            $orderTime = $row['Time'];
            $orderStatus = $row['Status'];
            $name = $row['Name'];
            $phone = $row['Phone'];
            $address = $row['Address'];
            $shipping = $row['Shipping'];
            $payment = $row['Payment'];
            $totalPrice = number_format($row['Total'], 0, ',', '.');
            $request = $row['Request'];
            if ($request == "") {
              $request = "No request";
            }
            
            echo "<div class='row' style='border-bottom: 2px solid black; padding: 20px;'>
                    <div class='col-12 col-md-6 col-lg-6 pb-2'>
                      <div class='product-container overflow-y-auto text-start' style=' width: 100%; height: 300px; overflow-x:hidden;'>";
            $result_1 = mysqli_query($conn, "SELECT * FROM orderproduct WHERE OrderID = '$orderId'");
            while ($row = mysqli_fetch_assoc($result_1)) {
              $query_1 = mysqli_query($conn, "SELECT * FROM product WHERE ProductID = '".$row['ProductID']."'");
              $product = mysqli_fetch_assoc($query_1);

              $query_2 = mysqli_query($conn, "SELECT * FROM productvariant WHERE ProductID = '".$row['ProductID']."' AND Color = '".$row['Color']."'");
              $variant = mysqli_fetch_assoc($query_2);

              echo "<div class='product d-flex pb-4'>
                      <div style='position: relative;'>
                        <img src='".$variant['Image']."' alt='".$product['Name']."' style='width: 90px; height: 90px; border-radius: 10px; margin-right: 20px; overflow:hidden;'>
                        <p class='quantity' style='display:flex; align-items:center; justify-content: center; position: absolute; width: 30px; height: 30px; border-radius: 15px; background-color: lightblue; top: -8px; right: 10px;'>".$row['Quantity']."</p>
                      </div>
                      
                      <div class='row justify-content-between' style='width: 100%;'>
                        <div class='col-8'>
                          <h6 class='text-break'>".$product['Name']."</h6>
                          <h6>".$variant['Color']."</h6>
                        </div>
                        <div class='col-4'>
                          <h6 class='align-self-center price' style='color: red;'>".number_format($row['Quantity'] * $product['Price'], 0, ',', '.')."đ</h6>
                        </div>
                      </div>
                    </div>";
            }
            echo          "</div>
                    </div>
                    <div class='col-12 col-md-6 col-lg-4 text-start gy-2'>
                      <h4>Order Information</h4>
                      <ul>
                        <li>Order ID: <span style='color: red; font-weight: bold;'>".$orderId."</span></li>
                        <li>Order Date: ".$orderDate." Time: ".$orderTime."</li>
                        <li>Receiver Name: ".$name."</li>
                        <li>Receiver Phone: ".$phone."</li>
                        <li>Receiver Address: ".$address."</li>
                        <li>Shipping Method: ".$shipping." Shipping</li>
                        <li>Payment Method: ".$payment."</li>";
                      if ($orderStatus == "Declined") {
                        echo "<li>Order Status: <span style='color: red; font-weight: bold; font-size: 20px;'>".$orderStatus."</span></li>";
                      } else {
                        echo "<li>Order Status: <span style='color: green; font-weight: bold;'>".$orderStatus."</span></li>";
                      }
                      
                      echo  "<li>Request: <span style='color: blue; font-weight: bold;'>".$request."</span></li>
                      </ul>
                      
                    </div>";
                    if ($orderStatus == "Declined") {
                      echo "<div class='col-12 col-md-12 col-lg-2 d-flex align-items-center text-start pt-3'>
                              <h3 style='text-decoration: line-through; text-decoration-color: red; text-decoration-thickness: 2px;'>Price: ".$totalPrice."đ</h3>
                            </div>
                          </div>";
                    } else {
                      echo "<div class='col-12 col-md-12 col-lg-2  align-items-center text-start pt-3'>
                              <h3>Price: ".$totalPrice."đ</h3>
                              <button data-id='".$orderId."' class='accept-btn btn btn-outline-success mt-5 d-lg-block'style='margin-left: 20px; width: 100px;'>Accept</button>
                              <button data-id='".$orderId."' class='decline-btn btn btn-outline-danger mt-5 pb-2' style='margin-left: 20px; width: 100px;'>Decline</button>
                            </div>
                          </div>";
                    }
                    
          }
        }
      ?>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
  <script src="js/admin.js"></script>
</body>
</html>