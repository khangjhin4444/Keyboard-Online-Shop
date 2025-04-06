<?php 
    session_set_cookie_params([
        'httponly' => true,  // Ngăn JavaScript truy cập session cookie
        'secure' => true,    // Chỉ gửi cookie qua HTTPS (chỉ bật khi dùng HTTPS)
        'samesite' => 'Strict' // Ngăn CSRF attack
    ]);
    session_start();
    $conn = mysqli_connect('localhost', 'root', '', 'keyboardshop');
    if (!isset($_SESSION['login'])) {
        $_SESSION['login'] = 'guest';
    }
    // if (!isset($_SESSION['login'])) {
    //     $id = $_SESSION['id'];
    // }

    if (isset($_SESSION['id']) && isset($_COOKIE['remember_token'])) {
        $token = $_COOKIE['remember_token'];
        $query = mysqli_query($conn, "SELECT userID FROM user_tokens WHERE token = '$token' AND expires_at > NOW()");
        // echo $token;
        if (mysqli_num_rows($query) > 0) {
            $row = mysqli_fetch_assoc($query);
            $_SESSION['id'] = $row['userID'];
        }
    }
?>
<?php 
    if (isset($_SESSION['id'])) {
        $userid = $_SESSION['id'];
        // echo $userid;
        $user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM user WHERE UserID = '$userid'"));
        $quantity = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(Quantity) AS total_items FROM cartproduct WHERE UserID = '$userid'"));
        $total_items = $quantity['total_items'] ?? 0;
        echo "<div class='screen-pop-up hidden'>
            <div class='pop-up'>
                <h2>Account information:</h2>
                <p>Name: {$user['Name']}</p>
                <p>Address: {$user['Address']}</p>
                <p>Phone Number: {$user['Phone']}</p>
                <div class='d-flex align-items-center justify-content-center'>
                    <button class='log-out-btn' style='
                        margin-top: 20px;
                        font-size: 20px;
                        padding: 10px 14px;
                        border: none;
                        border-radius: 10px;
                        font-weight: bold;
                        cursor: pointer;
                    '>Log Out</button>
                    <button class='view-orders-btn' style='
                        margin-top: 20px;
                        font-size: 20px;
                        padding: 10px 14px;
                        border: none;
                        border-radius: 10px;
                        font-weight: bold;
                        cursor: pointer;
                        margin-left: 20px;
                        background-color: #5C7285;
                        color:#E2E0C8;
                    '>View Orders</button>
                </div>
            </div>
        </div>
        
        <script>
            document.querySelector('.log-out-btn').addEventListener('click', () => {
                window.location.href = 'logout.php'
            })

            document.querySelector('.view-orders-btn').addEventListener('click', () => {
                window.location.href = '?page=view_orders.php'
            })
        </script>";
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                document.querySelector('.profile-btn').addEventListener('click', function() {
                    document.querySelector('.screen-pop-up').classList.remove('hidden');
                });
                document.querySelector('.profile-btn-top').addEventListener('click', function() {
                    document.querySelector('.screen-pop-up').classList.remove('hidden');
                });
                document.querySelector('.cart-quantity').innerHTML = '  $total_items  ';
                document.querySelector('.cart-btn').addEventListener('click', function() {
                    window.location.href = '?page=cart_view.php';
                });
            });
        </script>";
    } else {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                document.querySelector('.profile-btn').addEventListener('click', function() {
                    window.location.href = 'authentication.php';
                });
                document.querySelector('.profile-btn-top').addEventListener('click', function() {
                    window.location.href = 'authentication.php';
                });
                document.querySelector('.cart-btn').addEventListener('click', function() {
                    window.location.href = 'authentication.php';
                });
            });
        </script>";
    }
    mysqli_close($conn);
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        .screen-pop-up {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .pop-up {
            width: 450px;
            height: 300px;
            background-color: white;
            border-radius: 30px;
            padding: 10px 25px;
            animation: slide-up 0.4s ease-out;
        }

        .hidden {
            display: none;
        }

        @keyframes slide-up {
            from { transform: translateY(100%); opacity: 0; }
            to { transform: translateY(0%); opacity: 1; }
        }

        @keyframes slide-out {
            from { transform: translateY(0%); opacity: 1; }
            to { transform: translateY(100%); opacity: 0; }
        }

        .slide-out {
            animation: slide-out 0.4s ease-out;
        }
    </style>
</head>
<body>
    
<header>
        <h1>JK Keyboard</h1>
        <button class="profile-btn-top">
            <img src="images/6522516.png">
        </button>

        <div class="topnav">
            <img class="logo" src="images/30368cfe-9abb-4c89-9de0-bde0e4405ac8.png">

            <div class="search-container">
                <input class="search-bar" type="text.sidebar {
    position: fixed;
    top: 0;
    left: -200px;
    width: 200px;
    height: 100%;
    background-color: #16404D;
    box-shadow: 2px 0 5px rgba(0, 0, 0, 0.2);
    transition: left 0.3s ease-in-out;
    z-index: 150;
    padding-top: 30px;
    }

    .sidebar.open {
    left: 0;
    }" placeholder="Search">
                <button class="search-btn">
                    <img src="images/search-icon.png">
                </button>
            </div>

            <div class="topnav-right">
                <button class="cart-btn">
                    <img src="images/cart-icon.png">
                    <div class="cart-quantity">0</div>
                </button>
                <button class="profile-btn">
                    <img src="images/6522516.png">
                </button>
            </div>
        </div>

        <button class="menu-toggle active">
          <img src="images/hamburger-menu.png">
        </button>

        <div class="sidebar">   
          <div>
            <li><a class='home' href="?page=home">Home</a></li>
            <li><a class="about" href="?page=about">About</a></li>
            <li><a class="services" href="?page=services">Services</a></li>
            <li><a class="contact" href="?page=contact">Contact</a></li>
          </div>
        </div>

        <div class="botnav">
            <nav>
                <ul>
                    <li><a class='home' href="?page=home">Home</a></li>
                    <li><a class="about" href="?page=about">About</a></li>
                    <li><a class="services" href="?page=services">Services</a></li>
                    <li><a class="contact" href="?page=contact">Contact</a></li>
                </ul>
            </nav>
        </div>
    </header>

    

    <script>
        

        document.addEventListener("DOMContentLoaded", function() {
            let params = new URLSearchParams(window.location.search);
            let page = params.get('page');
            if (page == 'home') {
                document.querySelectorAll(".home").forEach(a => {
                    a.style.borderBottom = '2px solid #E2E0C8';
                })
            } else if (page == 'about') {
                document.querySelectorAll(".about").forEach(a => {
                    a.style.borderBottom = '2px solid #E2E0C8';
                })
            } else if (page == 'services') {
                document.querySelectorAll(".services").forEach(a => {
                    a.style.borderBottom = '2px solid #E2E0C8';
                })
            } else if (page == 'contact') {
                document.querySelectorAll(".contact").forEach(a => {
                    a.style.borderBottom = '2px solid #E2E0C8';
                })
            }

            const popUp = document.querySelector('.screen-pop-up');
            const profileBtn = document.querySelector('.profile-btn');

            if (popUp) {
                // Sự kiện click bên ngoài pop-up để đóng
                popUp.addEventListener("click", (event) => {
                    // Kiểm tra nếu click không phải vào nội dung pop-up
                    if (event.target === popUp) {
                        closePopup();
                    }
                });
            }

            function closePopup() {
                // Thêm lớp slide-out vào pop-up
                const popUpContent = document.querySelector('.pop-up');
                popUpContent.classList.add('slide-out');

                // Đặt timeout để thêm lại class hidden sau khi animation kết thúc
                setTimeout(() => {
                    popUp.classList.add('hidden');
                    popUpContent.classList.remove('slide-out');
                }, 200); // Thời gian phải khớp với thời lượng animation (0.4s)
            }
        });
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelector(".logo").addEventListener("click", function() {
                window.location.href = "?page=home.php";
            });
        });
    </script>
</body>
</html>