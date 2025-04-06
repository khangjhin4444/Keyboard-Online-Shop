<?php 
    session_set_cookie_params([
        'httponly' => true,  // Ngăn JavaScript truy cập session cookie
        'secure' => true,    // Chỉ gửi cookie qua HTTPS (chỉ bật khi dùng HTTPS)
        'samesite' => 'Strict' // Ngăn CSRF attack
    ]);
    session_start();
    $_SESSION = [];
    if (isset($_COOKIE['remember_token'])) {
        $token = $_COOKIE['remember_token'];
        $conn = mysqli_connect('localhost', 'root', '', 'keyboardshop');
        $query = mysqli_query($conn, "DELETE FROM user_tokens WHERE token = '$token'");
        mysqli_close($conn);
    }
    
    // Xóa cookie
    setcookie('remember_token', '', time() - 3600, "/");
    session_unset();
    session_destroy();
    header("Location: index.php");
?>