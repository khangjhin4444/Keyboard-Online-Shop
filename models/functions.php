<?php 
  function renderCard($type, $id) {
    $conn = mysqli_connect("localhost", "root", "", "keyboardshop");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Truy vấn lấy 8 sản phẩm đầu tiên của loại $type
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
            LIMIT 8;";
    
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

    $check_sql = "SELECT COUNT(*) AS total FROM Product WHERE ProductType = '$type'";
    $check_result = mysqli_query($conn, $check_sql);
    $check_row = mysqli_fetch_assoc($check_result);
    $total_products = $check_row['total'];

    if ($total_products <= 8) {
        echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    document.querySelectorAll(".show-more-btn").forEach(btn => {
                        if (btn.id === "'.$id.'") {
                            btn.style.display = "none";
                            console.log("No more products to load.");
                        }
                    });
                });
              </script>';
    }

    mysqli_close($conn);
  }


  function renderSearch($type, $keyword) {
    $keyword = iconv('UTF-8', 'ASCII//TRANSLIT', $keyword);
    $conn = mysqli_connect("localhost", "root", "", "keyboardshop");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT p.ProductId as id,
                p.Name AS name, 
                p.Price AS price, 
                (SELECT pv.Image 
                FROM productvariant pv 
                WHERE pv.ProductID = p.ProductID 
                ORDER BY pv.Color ASC 
                LIMIT 1) AS image
            FROM product p
            WHERE p.ProductType = '$type' and (p.Name LIKE '%$keyword%' or p.Description LIKE '%$keyword%')";
    
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) == 0) {
        return;
    }
    
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
    // $check_sql = "SELECT COUNT(*) AS total FROM Product WHERE ProductType = '$type'";
    // $check_result = mysqli_query($conn, $check_sql);
    // $check_row = mysqli_fetch_assoc($check_result);
    // $total_products = $check_row['total'];

    // if ($total_products <= 8) {
    //     echo '<script>
    //             document.addEventListener("DOMContentLoaded", function() {
    //                 document.querySelectorAll(".show-more-btn").forEach(btn => {
    //                     if (btn.id === "2") {
    //                         btn.style.display = "none";
    //                         console.log("No more products to load.");
    //                     }
    //                 });
    //             });
    //           </script>';
    // }

    mysqli_close($conn);
  }
?>