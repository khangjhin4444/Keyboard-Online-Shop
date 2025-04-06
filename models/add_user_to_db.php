<?php 
$data = json_decode(file_get_contents("php://input"), true);
$conn = mysqli_connect('localhost', 'root', '', 'keyboardshop');
$response = ['invalid' => false];
$query_1 = mysqli_query($conn, "SELECT * FROM user WHERE Phone = '".$data['phone']."'");
$row_1 = mysqli_num_rows($query_1);
$query_2 = mysqli_query($conn, "SELECT * FROM user WHERE username = '".$data['username']."'");
$row_2 = mysqli_num_rows($query_2);

if ($row_1 > 0 || $row_2 > 0 || strlen($data['phone']) != 10 || !preg_match('/[A-Z]/', $data['password']) || !preg_match('/[0-9]/', $data['password']) || !preg_match('/^[0][1-9][0-9]{8}$/', $data['phone']) || strlen($data['password']) > 20 || strlen($data['password']) < 10) {
  $response['invalid'] = true;
  exit;
}
$name = $data['name'];
$address = $data['address'];
$phone = $data['phone'];
$username = $data['username'];
$hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
$result = mysqli_query($conn, "INSERT INTO user (Name, Address, Phone, username, password) VALUES ('$name', '$address', '$phone', '$username', '$hashedPassword')");
echo json_encode($response);
mysqli_close($conn);
?>