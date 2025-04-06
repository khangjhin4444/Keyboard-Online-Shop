<?php 
  session_set_cookie_params([
    'httponly' => true,  // Ngăn JavaScript truy cập session cookie
    'secure' => true,    // Chỉ gửi cookie qua HTTPS (chỉ bật khi dùng HTTPS)
    'samesite' => 'Strict' // Ngăn CSRF attack
  ]);
  session_start();
  $data = json_decode(file_get_contents("php://input"), true);
  $conn = mysqli_connect('localhost', 'root', '', 'keyboardshop');
  $response = ['success' => true, 'admin' => false];
  $username = $data['username'];
  $password = $data['password'];
  $user = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");
  if (mysqli_num_rows($user) > 0) {
    $row = mysqli_fetch_assoc($user);
    if ($password == password_verify($password, $row['password'])) {
      if ($username == 'admin') {
        $_SESSION['login'] = 'admin';
        $_SESSION['id'] = $row['UserID'];
        $response['admin'] = true;
        echo json_encode($response);
        mysqli_close($conn);
        exit;
      }
      $_SESSION['login'] = 'user';
      $_SESSION['id'] = $row['UserID'];

      $token = bin2hex(random_bytes(32));

      $user_id = $row['UserID'];
      $expiry = date('Y-m-d H:i:s', time() + (7 * 24 * 60 * 60)); //7 days

      $query = mysqli_query($conn, "INSERT INTO user_tokens (userID, token, expires_at) VALUES ('$user_id', '$token', '$expiry')");
      
      // Lưu token vào cookie
      setcookie('remember_token', $token, time() + (7 * 24 * 60 * 60), "/", "", false, true); // HttpOnly = true
    } else {
      $response['success'] = false;
    }
  } else {
    $response['success'] = false;
  }
  echo json_encode($response);
  mysqli_close($conn)
?>