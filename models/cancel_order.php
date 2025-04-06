<?php 
  session_start();
  if ($_SESSION['login'] != 'user') {
    header("Location: index.php");
    exit;
  }

  if (isset($_GET['OrderID'])) {
    $orderID = $_GET['OrderID'];

    $conn = mysqli_connect('localhost', 'root', '', 'keyboardshop');
    mysqli_query($conn, "UPDATE orders SET Status = 'Canceled' WHERE OrderID = '$orderID'");

    mysqli_close($conn);
    echo json_encode(['status' => 'success', 'orderID' => $orderID]);
  }
?>