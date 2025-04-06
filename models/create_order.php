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
  if (isset($_GET['name'])) {
    $name = $_GET['name'];
    $phone = $_GET['phone'];
    $address = $_GET['address'];
    $request = $_GET['request'];
    $shipping = $_GET['shipping'];
    $payment = $_GET['payment'];
    $date = $_GET['date'];
    $time = $_GET['time'];
    $total = $_GET['total'];
    $total = str_replace(['.', 'đ'], '', $total);
  }
  if (!preg_match('/^[0][1-9][0-9]{8}$/', $phone) || empty($name) || empty($phone) || empty($address) || empty($shipping) || empty($payment) || empty($date) || empty($time)) {
    echo "error";
    exit();
  }
  $conn = mysqli_connect('localhost', 'root', '', 'keyboardshop');
  $result = mysqli_query($conn, "INSERT INTO orders (UserID, Name, Phone, Address, Request, Shipping, Payment, Date, Time, Status, Total) VALUES ('$userId', '$name', '$phone', '$address', '$request', '$shipping', '$payment', '$date', '$time', 'Pending', '$total')");
  $orderId = mysqli_insert_id($conn);
  $result = mysqli_query($conn, "SELECT * FROM cartproduct WHERE UserID = '$userId'");
  while ($row = mysqli_fetch_assoc($result)) {
    $productID = $row['ProductID'];
    $color = $row['Color'];
    $quantity = $row['Quantity'];
    $query = mysqli_query($conn, "INSERT INTO orderproduct (OrderID, ProductID, Color, Quantity) VALUES ('$orderId', '$productID', '$color', '$quantity')");
  }
  $query_1 = mysqli_query($conn, "SELECT * FROM cartproduct WHERE UserID = '$userId'");
  $cart = mysqli_fetch_assoc($query_1);
  $productID = $cart['ProductID'];
  $color = $cart['Color'];
  $quantity = $cart['Quantity'];
  $query_2 = mysqli_query($conn, "SELECT stock FROM productvariant WHERE ProductID = '$productID' AND Color = '$color'");
  
  $stockQuantity = mysqli_fetch_assoc($query_2);
  if ($stockQuantity) {
    if ($stockQuantity['stock'] <= $quantity) {
      mysqli_query($conn, "DELETE FROM cartproduct WHERE ProductID = '$productID' AND Color = '$color'");
  
      mysqli_query($conn, "UPDATE productvariant SET stock = 0 WHERE ProductID = '$productID' AND Color = '$color'");
    } else {
      $newStockQuantity = $stockQuantity['stock'] - $quantity;
      mysqli_query($conn, "UPDATE productvariant SET stock = '$newStockQuantity' WHERE ProductID = '$productID' AND Color = '$color'");
  
      mysqli_query($conn, "UPDATE cartproduct SET Quantity = '$newStockQuantity' WHERE ProductID = '$productID' AND Color = '$color'");
    }
  }

  mysqli_query($conn, "DELETE FROM cartproduct WHERE UserID = '$userId'");
  
  echo json_encode(['status' => 'success', 'orderId' => $orderId]);
  mysqli_close($conn);
?>