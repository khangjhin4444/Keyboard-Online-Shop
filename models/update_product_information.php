<?php 
  session_start();
  if ($_SESSION['login'] != 'admin') {
    exit;
  }

  if (isset($_GET['updateVariant']) && $_GET['updateVariant'] == true) {
    $productID = $_POST['ProductID'];
    $oldColors = $_POST['OldColor'];
    $colors = $_POST['Color'];
    $stocks = $_POST['Stock'];
    $conn = mysqli_connect('localhost', 'root', '', 'keyboardshop');
    for ($i = 0; $i < count($colors); $i++) {
      $oldColor = $oldColors[$i];
      $color = $colors[$i];
      $stock = $stocks[$i];

      // mysqli_query($conn, "UPDATE cartproduct SET Color = '$color' WHERE ProductID = '$productID' AND Color = '$oldColor'");

      mysqli_query($conn, "UPDATE productvariant SET Color = '$color', stock = '$stock' WHERE ProductID = '$productID' AND Color = '$oldColor'");
      $response[] = [
        'color' => $color,
        'stock' => $stock
      ];
    }
    mysqli_close($conn);
    echo json_encode(['status' => 'success', 'data' => $response]);
    exit;
  }


  if (isset($_GET['ProductID'])) {
    $productID = $_GET['ProductID'];
    $name = $_GET['name'];
    $price = $_GET['price'];
    $description = $_GET['description'];
    $newProductType = $_GET['ProductType'];
    $newSize = $_GET['Size'];
    $newProfile = $_GET['Profile'];
    $newType = $_GET['Type'];
    $newURL = $_GET['SoundTest'];
  }

  $conn = mysqli_connect('localhost', 'root', '', 'keyboardshop');
  $query = mysqli_query($conn, "UPDATE product SET Name = '$name', Price = '$price', Description = '$description', ProductType = '$newProductType', Size = '$newSize', Profile = '$newProfile', Type = '$newType', Soundtest = '$newURL' WHERE ProductID = '$productID'");

  echo json_encode(["size" => $newSize]);
  mysqli_close($conn);
?>