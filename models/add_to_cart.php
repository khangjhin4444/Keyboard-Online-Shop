<?php
session_set_cookie_params([
    'httponly' => true,  // Ngăn JavaScript truy cập session cookie
    'secure' => true,    // Chỉ gửi cookie qua HTTPS (chỉ bật khi dùng HTTPS)
    'samesite' => 'Strict' // Ngăn CSRF attack
]);
session_start();
header('Content-Type: application/json');

if (isset($_SESSION['id']) && isset($_GET["productID"])) {
    $id = $_SESSION['id'];
    $productId = $_GET['productID'];
    $color = $_GET['color'] ?? 'Basic';
    $quantity = $_GET['quantity'] ?? 1;

    $conn = mysqli_connect('localhost', 'root', '', 'keyboardshop');

    $query = "SELECT Quantity FROM cartproduct WHERE UserID = '$id' AND ProductID = '$productId' AND Color = '$color'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        $newQuantity = $row['Quantity'] + $quantity;
        $updateQuery = "UPDATE cartproduct SET Quantity = '$newQuantity' WHERE UserID = '$id' AND ProductID = '$productId' AND Color = '$color'";
        $updateResult = mysqli_query($conn, $updateQuery);
    } else {
        $insertQuery = "INSERT INTO cartproduct (UserID, ProductID, Color, Quantity) VALUES ('$id','$productId', '$color', '$quantity')";
        $insertResult = mysqli_query($conn, $insertQuery);
    }

    echo json_encode([
        'success' => true,
        'productID' => $productId,
        'color' => $color,
        'quantity' => $row ? $newQuantity : $quantity
    ]);

    mysqli_close($conn);
}
?>
