<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "keyboardshop");
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

if (isset($_GET['sub'])) {
  $sub = $_GET['sub'];
}

$offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
if (isset($_GET["ProductType"])) {
  $type  = ($_GET['ProductType']);
}
$orderBy = "ProductID"; 
$orderDir = "ASC";

if (isset($_GET["sort_name"]) && $_GET["sort_name"] !== "default") {
  $orderBy = "name";
  $orderDir = ($_GET["sort_name"] === "asc") ? "ASC" : "DESC";
}

if (isset($_GET["sort_price"]) && $_GET["sort_price"] !== "default") {
  $orderBy = "price";
  $orderDir = ($_GET["sort_price"] === "asc") ? "ASC" : "DESC";
}

// Truy vấn có offset và sort
if (isset($_GET['sub'])) {
  $sub = $_GET['sub'];
  if ($type == 'KeyboardKit' || $type == 'Prebuild') {
    $sql = "SELECT p.ProductId AS id,
                          p.Name AS name, 
                          p.Price AS price, 
                          (SELECT pv.Image 
                          FROM productvariant pv 
                          WHERE pv.ProductID = p.ProductID 
                          ORDER BY pv.Color ASC 
                          LIMIT 1) AS image
                      FROM product p
                      WHERE p.ProductType = '$type' AND p.Size = '$sub'
                      ORDER BY $orderBy $orderDir LIMIT 8 OFFSET $offset";
  }
  if ($type == 'Keycap') {
    $sql = "SELECT p.ProductId AS id,
                          p.Name AS name, 
                          p.Price AS price, 
                          (SELECT pv.Image 
                          FROM productvariant pv 
                          WHERE pv.ProductID = p.ProductID 
                          ORDER BY pv.Color ASC 
                          LIMIT 1) AS image
                      FROM product p
                      WHERE p.ProductType = '$type' AND p.Profile = '$sub'
                      ORDER BY $orderBy $orderDir LIMIT 8 OFFSET $offset";
  } 
  if ($type == 'Switch') {
    $sql = "SELECT p.ProductId AS id,
                          p.Name AS name, 
                          p.Price AS price, 
                          (SELECT pv.Image 
                          FROM productvariant pv 
                          WHERE pv.ProductID = p.ProductID 
                          ORDER BY pv.Color ASC 
                          LIMIT 1) AS image
                      FROM product p
                      WHERE p.ProductType = '$type' AND p.Type = '$sub'
                      ORDER BY $orderBy $orderDir LIMIT 8 OFFSET $offset";
  } 
} else {
  $sql = "SELECT p.ProductId AS id,
                        p.Name AS name, 
                        p.Price AS price, 
                        (SELECT pv.Image 
                        FROM productvariant pv 
                        WHERE pv.ProductID = p.ProductID 
                        ORDER BY pv.Color ASC 
                        LIMIT 1) AS image
                    FROM product p
                    WHERE p.ProductType = '$type'
                    ORDER BY $orderBy $orderDir LIMIT 8 OFFSET $offset";
}




$result = mysqli_query($conn, $sql);
$product_count = mysqli_num_rows($result);


$response = ["products" => "", "end" => false];

while ($row = mysqli_fetch_assoc($result)) {
  if ($_SESSION['login'] == 'guest') {
    $response["products"] .= '<div class="col col-12 col-xxl-3 col-xl-4 col-md-6 text-center">';
    $response["products"] .= '<div class="card" style="width: 100%; height: 100%">';
    $response["products"] .= "<a href='authentication.php'><img src='{$row["image"]}' class='card-img-top' style='width: 100%; height: 300px; object-fit:cover' alt='{$row["name"]}'></a>";
    $response["products"] .= '<div class="card-body">';
    $response["products"] .= '<h5 class="card-title" style="font-size: 16px;">' . $row["name"] . '</h5>';
    $response["products"] .= '<p class="card-text">Price: ' . number_format($row["price"], 0, ',', '.') . 'đ</p>';
    $response["products"] .= '<a href="authentication.php" class="btn btn-primary">VIEW MORE</a>';
    $response["products"] .= '</div></div></div>';
  }
  else {
    $response["products"] .= '<div class="col col-12 col-xxl-3 col-xl-4 col-md-6 text-center">';
    $response["products"] .= '<div class="card" style="width: 100%; height: 100%">';
    $response["products"] .= "<a href='?page=product.php&productId={$row['id']}'><img src='{$row["image"]}' class='card-img-top' style='width: 100%; height: 300px; object-fit:cover' alt='{$row["name"]}'></a>";
    $response["products"] .= '<div class="card-body">';
    $response["products"] .= '<h5 class="card-title" style="font-size: 16px;">' . $row["name"] . '</h5>';
    $response["products"] .= '<p class="card-text">Price: ' . number_format($row["price"], 0, ',', '.') . 'đ</p>';
    $response["products"] .= '<a href="?page=product.php&productId='.$row['id'].'" class="btn btn-primary">VIEW MORE</a>';
    $response["products"] .= '</div></div></div>';
  }
  
}

// Nếu số sản phẩm trả về < 8 thì đặt flag "end" thành true
if ($product_count < 8) {
  $response["end"] = true;
}
$check_sql = "SELECT COUNT(*) AS total FROM Product WHERE ProductType = '$type'";
$check_result = mysqli_query($conn, $check_sql);
$check_row = mysqli_fetch_assoc($check_result);
$total_products = $check_row['total'];

if ($offset + 8 >= $total_products) {
    $response["end"] = true;
}



// Trả về JSON
echo json_encode($response);

mysqli_close($conn);
?>
