<?php 
  if (isset($_GET['name'])) {
    $name = $_GET['name'];
    $conn = mysqli_connect('localhost', 'root', '', 'keyboardshop');
    $query = mysqli_query($conn, "SELECT Name FROM product WHERE Name = '$name'");
    if (mysqli_num_rows($query) == 0) {
      echo json_encode(['status' => 'ok']);
    } else {
      echo json_encode(['status' => 'fail']);
    }
    mysqli_close($conn);
    exit;
  }
?>