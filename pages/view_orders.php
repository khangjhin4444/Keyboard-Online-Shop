<?php
include "component/category.html";
if (!isset($_SESSION['id'])) {
    header("Location: index.php");
    exit();
}
$userid = $_SESSION['id'];
// $conn = mysqli_connect('localhost', 'root', '', 'keyboardshop');
// $result = mysqli_query($conn, "SELECT * FROM orders WHERE UserID = '$userid'");
// $order = mysqli_fetch_assoc($result);
// $orderId = $order['OrderID'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Orders</title>
  <link rel="stylesheet" href="css/cart_view.css">
</head>
<body>
  <div class="container text-start mb-3" style="border-bottom: 2px solid black;">
    <h2>Your Orders</h2>
  </div>
  <div class='container order-container'>
    <?php
      $conn = mysqli_connect('localhost', 'root', '', 'keyboardshop');
      $result = mysqli_query($conn, "SELECT * FROM orders WHERE UserID = '$userid' ORDER BY Date DESC, Time DESC");
      if (mysqli_num_rows($result) == 0) {
        echo "<div style='font-size: 30px; font-weight: bold;'>No orders found!</div>";
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
                    <div style='position: relative;' data-id='".$product['ProductID']."'>
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
                    if ($orderStatus == "Declined" || $orderStatus == "Canceled") {
                      echo "<li>Order Status: <span style='color: red; font-weight: bold; font-size: 20px;'>".$orderStatus."</span></li>";
                    } else if ($orderStatus == "Delivered") {
                      echo "<li>Order Status: <span style='color: green; font-weight: bold; font-size: 20px;'>".$orderStatus."</span></li>";
                    } else {
                      echo "<li>Order Status: <span style='color: gray; font-weight: bold; font-size: 20px;'>".$orderStatus."</span></li>";
                    }
                    
                    echo  "<li>Request: <span style='color: blue; font-weight: bold;'>".$request."</span></li>
                    </ul>
                    
                  </div>";
                  if ($orderStatus == "Declined" || $orderStatus == "Canceled") {
                    echo "<div class='col-12 col-md-12 col-lg-2 d-flex align-items-center text-start pt-3'>
                            <h3 style='text-decoration: line-through; text-decoration-color: red; text-decoration-thickness: 2px;'>Price: ".$totalPrice."đ</h3>
                          </div>
                        </div>";
                  } else if ($orderStatus == "Pending") {
                    echo "<div class='col-12 col-md-12 col-lg-2 d-flex align-items-center text-start pt-3'>
                            <h3>Price: ".$totalPrice."đ</h3>
                          </div>
                          <button data-id='".$orderId."' class='cancel-btn btn btn-outline-danger mt-5 ms-auto' style='width: 100px; font-weight: bold;'>CANCEL ORDER</button>
                        </div>";
                    
                  } else {
                    echo "<div class='col-12 col-md-12 col-lg-2 d-flex align-items-center text-start pt-3'>
                            <h3>Price: ".$totalPrice."đ</h3>
                          </div>
                        </div>";
                  }
                  
        }
      }
    ?>

    <!-- <div class="row">
      <div class="col-12 col-md-6 col-lg-6 pb-2">
        <div class='product-container overflow-y-auto text-start' style='background-color:lightblue; width: 100%; height: 300px; overflow-x:hidden;'>
        
        </div>
      </div>
      <div class="col-12 col-md-6 col-lg-4 text-start gy-2">
        <h4>Order Information</h4>
        <ul>
          <li>Order ID: <span style="color: red; font-weight: bold;">123456</span></li>
          <li>Order Date: 2023-10-01 Time: 21:00</li>
          <li>Receiver Name: John Doe</li>
          <li>Receiver Phone: 123456789</li>
          <li>Receiver Address: 123 Main St, City, Countrysdsdsdsdsdsdsdsdsd</li>
          <li>Shipping Method: Fast Shipping</li>
          <li>Payment Method: COD</li>
          <li>Order Status: <span style="color: green; font-weight: bold;">Delivered</span></li>
          <li>Request: <span style="color: blue; font-weight: bold;">Please deliver before 5 PM</span></li>
        </ul>
        
      </div>
      <div class="col-12 col-md-12 col-lg-2 d-flex align-items-center text-start pt-3">
        <h3>Price: 300.000</h3>
      </div>
    </div> -->
    
  </div>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      let cancelBtns = document.querySelectorAll('.cancel-btn')
      cancelBtns.forEach(btn => {
        btn.addEventListener('click', () => {
          fetch(`models/cancel_order.php?OrderID=${btn.dataset.id}`).then(res => res.json())
          .then(data => {
            alert("Canceled Order!")
            location.reload()
            // console.log(data)
          })
        })
      })
    })
  </script>
</body>
</html>