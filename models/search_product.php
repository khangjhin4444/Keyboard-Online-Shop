<?php 
  if (isset($_GET['keyword'])) {
    $keyword = $_GET['keyword'];

    $conn = mysqli_connect('localhost', 'root', '', 'keyboardshop');
    $query = mysqli_query($conn, "SELECT * FROM product WHERE Name LIKE '%$keyword%'");
    $response = [];
    while ($row = mysqli_fetch_assoc($query)) {
      $productID = $row['ProductID'];
      $variantQuery = mysqli_query($conn, "SELECT * FROM productvariant WHERE ProductID = '$productID'");

      $variants = [];

      while ($variant = mysqli_fetch_assoc($variantQuery)) {
        $variants[] = [
          'Color' => $variant['Color'],
          'Image' => $variant['Image'],
          'Stock' => $variant['stock']
        ];
      }

      $response[] = [
        'ProductID' => $row['ProductID'],
        'Name' => $row['Name'],
        'Description' => $row['Description'],
        'Price' => $row['Price'],
        'ProductType' => $row['ProductType'],
        'Size' => $row['Size'],
        'Profile' => $row['Profile'],
        'Type' => $row['Type'],
        'SoundTest' => $row['Soundtest'],
        'Variants' => $variants
      ];
    }
    mysqli_close($conn);
    echo json_encode($response);
  }
?>