<?php 
  session_start();
  if ($_SESSION['login'] != 'admin') {
    exit;
  }
  if (isset($_GET['OrderID']) && $_GET['status'] == 'accept') {
    $orderID = $_GET['OrderID'];
    $status = 'Delivered';
  }

  if (isset($_GET['OrderID']) && $_GET['status'] == 'decline') {
    $orderID = $_GET['OrderID'];
    $status = 'Declined';
  }

  $conn = mysqli_connect('localhost', 'root', '', 'keyboardshop');
  mysqli_query($conn, "UPDATE orders SET Status = '$status' WHERE OrderID = '$orderID'");
  mysqli_close($conn);
  echo json_encode(['orderID' => $orderID, 'Status' => $status]);
?>