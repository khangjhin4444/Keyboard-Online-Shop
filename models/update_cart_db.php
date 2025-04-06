<?php
if (session_status() == PHP_SESSION_NONE) {
  session_set_cookie_params([
    'httponly' => true,  // Ngăn JavaScript truy cập session cookie
    'secure' => true,    // Chỉ gửi cookie qua HTTPS (chỉ bật khi dùng HTTPS)
    'samesite' => 'Strict' // Ngăn CSRF attack
  ]);
  session_start();
}
$userid = $_SESSION['id'];
  function updateCartProduct($userid, $productID, $color, $quantity) {
    $conn = mysqli_connect('localhost', 'root', '', 'keyboardshop');
    if ($quantity == 0) {
      $result = mysqli_query($conn, "DELETE FROM cartproduct WHERE UserID = '{$userid}' AND ProductID = '{$productID}' AND Color = '{$color}';");
    } else {
      $result = mysqli_query($conn, "UPDATE cartproduct SET Quantity = '{$quantity}' WHERE UserID = '{$userid}' AND ProductID = '{$productID}' AND Color = '{$color}';");
    }
  }

  if (isset($_GET['ProductID']) && isset($_GET['color']) && isset($_GET['quantity'])) {
    echo $_GET['ProductID'];
    updateCartProduct($userid, $_GET['ProductID'], $_GET['color'], $_GET['quantity']);
  }
?>