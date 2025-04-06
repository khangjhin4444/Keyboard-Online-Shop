<?php 
  if (isset($_GET['ProductID'])) {
    $productID = $_GET['ProductID'];
    $color = $_GET['color'];
    $quantity = $_GET['quantity'];
  }
  $conn = mysqli_connect('localhost', 'root', '', 'keyboardshop');
  $result = mysqli_query($conn, "SELECT * FROM productvariant WHERE ProductID = '$productID' AND Color = '$color' AND stock >= $quantity");
  $response = ['stock' => false];
  if (mysqli_num_rows($result) > 0) {
    $response['stock'] = true;
  }
  echo json_encode($response);
  mysqli_close($conn)
?>