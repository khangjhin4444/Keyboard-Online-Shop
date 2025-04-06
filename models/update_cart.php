<?php 
session_set_cookie_params([
  'httponly' => true,  // Ngăn JavaScript truy cập session cookie
  'secure' => true,    // Chỉ gửi cookie qua HTTPS (chỉ bật khi dùng HTTPS)
  'samesite' => 'Strict' // Ngăn CSRF attack
]);
session_start();
$conn = mysqli_connect('localhost', 'root', '', 'keyboardshop');
$userid = $_SESSION['id'];
// echo $userid;
$user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM user WHERE UserID = '$userid'"));
$quantity = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(Quantity) AS total_items FROM cartproduct WHERE UserID = '$userid'"));
$total_items = $quantity['total_items'] ?? 0;
echo $total_items;
mysqli_close($conn);
?>