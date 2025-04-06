<?php
  session_start();
  if ($_SESSION['login'] != 'admin') {
    exit;
  }

  if (isset($_GET['ProductID'])) {
    $productID = $_GET['ProductID'];
    $conn = mysqli_connect('localhost', 'root', '', 'keyboardshop');

    $query = mysqli_query($conn, "SELECT * FROM orderproduct WHERE ProductID = '$productID'");
    while ($order = mysqli_fetch_assoc($query)) {
      $orderID = $order['OrderID'];

      $query_1 = mysqli_query($conn, "UPDATE orders SET Status = 'Declined' WHERE OrderID = $orderID");
    }

    mysqli_query($conn, "DELETE FROM product WHERE ProductID = '$productID'");
    mysqli_close($conn);
    // echo $query;
  }
?>