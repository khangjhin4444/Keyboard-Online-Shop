<?php 
  $conn = mysqli_connect("localhost", 'root', '', 'keyboardshop');
  if (isset($_POST['username'])) {
    $username = $_POST['username'];
  }
  if (isset($_POST['password'])) {
    $password = $_POST['password'];
  }

  if (isset($_POST['phone'])) {
    $phone = $_POST['phone'];
    $result = mysqli_query($conn, "SELECT * FROM user WHERE Phone = '$phone'");
  } else {
    $result = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");
  }


  $response = ['exist' => false, 'passCheck' => false, 'phone' => false];
  $row = mysqli_num_rows($result);
  if ($row > 0) {
    $response['exist'] = true;
  }
  if (isset($_POST['password'])) {
    if (strlen($password) > 20 || strlen($password) < 10 || !preg_match('/[A-Z]/', $password) || !preg_match('/[0-9]/', $password)) {
      $response['passCheck'] = true;
    }
  }
  
  echo json_encode($response);

  mysqli_close($conn);
?>
