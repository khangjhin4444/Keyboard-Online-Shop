<?php
session_set_cookie_params([
  'httponly' => true,  // Ngăn JavaScript truy cập session cookie
  'secure' => true,    // Chỉ gửi cookie qua HTTPS (chỉ bật khi dùng HTTPS)
  'samesite' => 'Strict' // Ngăn CSRF attack
]);
session_start();
$conn = mysqli_connect("localhost", "root", "", "keyboardshop");
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
if (isset($_GET["ProductType"])) {
  $type = $_GET['ProductType'];
}

$orderBy = "ProductID"; // Mặc định sắp xếp theo id
$orderDir = "ASC"; // Mặc định tăng dần

if (isset($_GET["sort_name"]) && $_GET["sort_name"] !== "default") {
  $orderBy = "name";
  $orderDir = ($_GET["sort_name"] === "asc") ? "ASC" : "DESC";
}

if (isset($_GET["sort_price"]) && $_GET["sort_price"] !== "default") {
  $orderBy = "price";
  $orderDir = ($_GET["sort_price"] === "asc") ? "ASC" : "DESC";
}

if (isset($_GET['sub'])) {
  $sub = $_GET['sub'];
  if ($type == 'KeyboardKit' || $type == 'Prebuild') {
    $sql = "SELECT          p.ProductId AS id,
                        p.Name AS name, 
                        p.Price AS price, 
                        (SELECT pv.Image 
                        FROM productvariant pv 
                        WHERE pv.ProductID = p.ProductID 
                        ORDER BY pv.Color ASC 
                        LIMIT 1) AS image
                    FROM product p
                    WHERE p.ProductType = '$type' AND p.Size = '$sub'
                    ORDER BY $orderBy $orderDir LIMIT 8";
  } else
  if ($type == 'Keycap') {
    $sql = "SELECT          p.ProductId AS id,
                        p.Name AS name, 
                        p.Price AS price, 
                        (SELECT pv.Image 
                        FROM productvariant pv 
                        WHERE pv.ProductID = p.ProductID 
                        ORDER BY pv.Color ASC 
                        LIMIT 1) AS image
                    FROM product p
                    WHERE p.ProductType = '$type' AND p.Profile = '$sub'
                    ORDER BY $orderBy $orderDir LIMIT 8";
  } else if ($type == 'Switch') {
    $sql = "SELECT          p.ProductId AS id,
                        p.Name AS name, 
                        p.Price AS price, 
                        (SELECT pv.Image 
                        FROM productvariant pv 
                        WHERE pv.ProductID = p.ProductID 
                        ORDER BY pv.Color ASC 
                        LIMIT 1) AS image
                    FROM product p
                    WHERE p.ProductType = '$type' AND p.Type = '$sub'
                    ORDER BY $orderBy $orderDir LIMIT 8";
  }

} else {
  $sql = "SELECT          p.ProductId AS id,
                        p.Name AS name, 
                        p.Price AS price, 
                        (SELECT pv.Image 
                        FROM productvariant pv 
                        WHERE pv.ProductID = p.ProductID 
                        ORDER BY pv.Color ASC 
                        LIMIT 1) AS image
                    FROM product p
                    WHERE p.ProductType = '$type'
                    ORDER BY $orderBy $orderDir LIMIT 8";
}
// $sql = "SELECT * FROM products WHERE category_id = $id ORDER BY $orderBy $orderDir LIMIT 8";

$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {
  if ($_SESSION['login'] == 'guest') {
    echo '<div class="col col-12 col-xxl-3 col-xl-4 col-md-6 text-center">';
    echo '<div class="card" style="width: 100%; height: 100%;">';
    echo "<a href='authentication.php'><img src='{$row["image"]}' class='card-img-top' style='width: 100%; height: 300px !important; object-fit:cover' alt='{$row["name"]}'></a>";
    echo '<div class="card-body" style="height: 150px;">';
    echo '<h5 class="card-title" style="font-size: 16px; height: 30px">' . $row["name"] . '</h5>';
    echo '<p class="card-text">Price: ' . number_format($row["price"], 0, ',', '.') . 'đ</p>';
    echo '<a href="authentication.php" class="btn btn-primary">VIEW MORE</a>';
    echo '</div></div></div>';
  } else {
    echo '<div class="col col-12 col-xxl-3 col-xl-4 col-md-6 text-center">';
    echo '<div class="card" style="width: 100%; height: 100%;">';
    echo "<a href='?page=product.php&productId={$row['id']}'><img src='{$row["image"]}' class='card-img-top' style='width: 100%; height: 300px !important; object-fit:cover' alt='{$row["name"]}'></a>";
    echo '<div class="card-body" style="height: 150px;">';
    echo '<h5 class="card-title" style="font-size: 16px; height: 30px">' . $row["name"] . '</h5>';
    echo '<p class="card-text">Price: ' . number_format($row["price"], 0, ',', '.') . 'đ</p>';
    echo "<a href='?page=product.php&productId={$row['id']}' class='btn btn-primary'>VIEW MORE</a>";
    echo '</div></div></div>';
  }
}
// Kiểm tra xem có nhiều hơn 8 sản phẩm không
$check_sql = "SELECT COUNT(*) AS total FROM Product WHERE ProductType = '$type'";
$check_result = mysqli_query($conn, $check_sql);
$check_row = mysqli_fetch_assoc($check_result);
$total_products = $check_row['total'];

if ($total_products <= 8) {
    echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                document.querySelector(".show-more-btn").style.display = "none";
            });
          </script>';
}
mysqli_close($conn);
?>
