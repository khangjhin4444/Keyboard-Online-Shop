<?php 
session_set_cookie_params([
  'httponly' => true,  // Ngăn JavaScript truy cập session cookie
  'secure' => true,    // Chỉ gửi cookie qua HTTPS (chỉ bật khi dùng HTTPS)
  'samesite' => 'Strict' // Ngăn CSRF attack
]);
session_start();
if (!isset($_SESSION['id'])) {
  header("Location: index.php");
  exit();
}
$userId = $_SESSION['id'];
$conn = mysqli_connect('localhost', 'root', '', 'keyboardshop');
$result = mysqli_query($conn, "SELECT * FROM user WHERE UserID = '$userId'");
$user = mysqli_fetch_assoc($result);
mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Check Out</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
  <link rel="stylesheet" href="css/checkout.css">
  <style>
    html, body {
      height: 100%;
      margin: 0;
      /* font-family: Roboto; */
      padding-left: 10px;
      padding-right: 10px;
    }
  </style>
</head>
<body>
  <section>
    <div class="container-fluid">
    <a href="index.php?page=home"><img src="images/30368cfe-9abb-4c89-9de0-bde0e4405ac8.png" alt="Logo image" srcset="" style="width: 90px; height: 90px; border-radius: 50%;margin-top: 20px;"></a>
      <div class="row pb-5" >
        <div class="col-12 col-lg-8 pt-4">
          <div class="row">
            <div class="col-12 col-lg-6 mt-4">
              <h4 class='py-3'>Receiver Information</h4>
                <div class="form-floating mb-3">
                  <input type="text" class="form-control name-input" id="floatingName" placeholder="Full Name" value="<?php echo $user['Name'] ?>">
                  <label for="floatingName">Full Name</label>
                </div>
                <div class="form-floating mb-3">
                  <input type="text" class="form-control phone-input" id="floatingPhone" placeholder="Phone" value="<?php echo $user['Phone'] ?>">
                  <label for="floatingPhone">Phone</label>
                </div>
                <div class="form-floating mb-3">
                  <input type="text" class="form-control address-input" id="floatingAddress" placeholder="Address" value="<?php echo $user['Address'] ?>">
                  <label for="floatingAddress">Address</label>
                </div>

                <div class="form-floating">
                  <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea" style="height: 100px"></textarea>
                  <label for="floatingTextarea">Special request (Optional)</label>
                </div>
            </div>
            <div class="col-12 col-lg-6 mt-4"  style="background-color:rgb(239, 239, 239); border-radius: 20px;">
              <h4 class='py-3'>Receiver Information</h4>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="shipping" id="fastShipping" checked>
                <label class="form-check-label" for="fastShipping">
                  Fast Shipping <span style="font-weight: bold; margin-left:10px; color: red;">60.000đ</span>
                </label>
                <p style="margin: 0; padding: 0;">Receive in 2-3 days</p>
                <p class="estimate-fast" style="color: blue; font-size: 20px;">Estimated: Mon, 07/04/2025</p>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="shipping" id="normalShipping" >
                <label class="form-check-label" for="normalShipping">
                  Normal Shipping <span style="font-weight: bold; margin-left:10px; color: red;">30.000đ</span>
                </label>
                <p style="margin: 0; padding: 0;">Receive in 5-7 days</p>
                <p class="estimate-normal" style="color: blue; font-size: 20px;">Estimated: Thu, 10/04/2025</p>
              </div>

              <h4 class="pt-2">Payment Method</h4>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="payment" id="cod" checked>
                <label class="form-check-label" for="cod">
                  Cash on Delivery
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="payment" id="banking" >
                <label class="form-check-label" for="banking">
                  Internet Banking
                </label>
              </div>
            </div>
          </div>
        </div>

        <div class="col-12 col-lg-4 pt-4 " >
          <div class="d-flex align-items-center pb-3">
            <h4 style="padding: 0; margin: 0;">Cart</h4>
            <p style="padding: 0; margin: 0; padding-left: 10px; font-size: 20px;">(7 Products)</p>
          </div>
          <div class="product-container overflow-y-auto p-2" style="width: 100%; height: 300px; overflow-x:hidden;">
            <?php
              $conn = mysqli_connect('localhost', 'root', '', 'keyboardshop');
              $result = mysqli_query($conn, "SELECT * FROM cartproduct WHERE UserID = '$userId'");
              while ($row = mysqli_fetch_assoc($result)) {
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
            ?>
            
          </div>
          <div class="d-flex justify-content-between align-items-center mt-5" style="width: 100%; padding: 10px; background-color: #f8f9fa; border-radius: 10px; box-shadow: 0 0 5px rgba(0,0,0,0.2);">
            <h4 style="margin: 0; padding: 0; font-size: 20px;">Total (Include shipping):</h4>
            <h4 class="total-price" style="margin: 0; padding: 0;"></h4>
          </div>
          <div class="d-flex justify-content-between  mt-3" style="width: 100%;">
            <button class="btn backBtn" id="backBtn" style="border: 1px solid black; font-size: 20px; padding: 10px 12px; font-weight: bold;">BACK TO CART</button>
            <button class="btn orderBtn" id="orderBtn" style="border: 1px solid black; font-size: 20px; padding: 10px 12px; font-weight: bold;">ODER NOW</button>  
          </div>
        </div>
      </div>
      
    </div>
  </section>

  <script src="https://cdn.jsdelivr.net/npm/dayjs@1/dayjs.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
  <script src="js/checkout.js" type="module"></script>
</body>
</html>