<?php
  session_start();
  if ($_SESSION['login'] != 'admin') {
    exit;
  }
  $uploadDir = 'variant-images/'; // Thư mục lưu ảnh


  $colors = $_POST['color'];
  $stocks = $_POST['stock'];
  $images = $_FILES['image'];
  $name = $_POST['Name'];
  $productType = $_POST['ProductType'];
  $size = $_POST['Size'];
  $profile = $_POST['Profile'];
  $type = $_POST['Type'];
  $soundTest = $_POST['SoundTest'];
  $description = $_POST['Description'];
  $price = $_POST['Price'];

  $response = [];

  $conn = mysqli_connect('localhost', 'root', '', 'keyboardshop');
  $query = mysqli_query($conn, "INSERT INTO product (Name, Description, Price, ProductType, Size, Profile, Type, Soundtest) VALUES ('$name', '$description', '$price', '$productType', '$size', '$profile', '$type', '$soundTest')");
  $newInsertID = mysqli_insert_id($conn);

  for ($i = 0; $i < count($colors); $i++) {
      $color = $colors[$i];
      $stock = $stocks[$i];

      $imageName = basename($images['name'][$i]);
      $targetPath = $uploadDir . $imageName;

      $savePath = "../variant-images/". $imageName;
      if (!file_exists($targetPath)) {
          move_uploaded_file($images['tmp_name'][$i], $savePath);
      }

      

      $query_1 = mysqli_query($conn, "INSERT INTO productvariant (ProductID, Color, Image, stock) VALUES ('$newInsertID', '$color' , '$targetPath', '$stock')");


      $response[] = [
          'color' => $color,
          'stock' => $stock,
          'image_path' => $targetPath
      ];
  }

  mysqli_close($conn);
  echo json_encode(['status' => 'success', 'data' => $response]);
?>