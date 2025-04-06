<?php
// if (isset($_SESSION['id'])) {
//   echo $_SESSION['id'];
//   echo $_SESSION['login'];
// } else {
//   echo 'No session';
// }
$page = isset($_GET['page']) ? $_GET['page'] : 'home';
$page = str_replace('.php', '', $page);

// $valid_pages = ['home', 'about', 'contact', 'services'];

// if (!in_array($page, $valid_pages)) {
//     $page = 'home'; 
// }

$page_path = "pages/{$page}.php";

if (!file_exists($page_path)) {
    $page_path = "pages/home.php";
}
include("component/header.php");
// session_unset();
// session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" href="css/style.css">
      <link rel="stylesheet" href="css/header.css">
      <link rel="stylesheet" href="css/home_body.css">
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;900&family=Roboto:wght@100;900&display=swap" rel="stylesheet">
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
  </head>
  <body>

    <main>
        <!-- <div class="container justify-content-between align-items-center category-dropdown d-none d-md-flex">
          <div class="dropdown-center">
            <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
              Keyboard Kit
            </button>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#">Full Size</a></li>
              <li><a class="dropdown-item" href="#">TKL</a></li>
              <li><a class="dropdown-item" href="#">75% or less</a></li>
              <li><a class="dropdown-item" href="#">Alice</a></li>
            </ul>
          </div>
          <div class="dropdown-center">
            <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
              Keycap
            </button>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#">Profile Cherry</a></li>
              <li><a class="dropdown-item" href="#">Profile MDA</a></li>
              <li><a class="dropdown-item" href="#">Profile SA</a></li>
              <li><a class="dropdown-item" href="#">Artisan</a></li> 
            </ul>
          </div>
          <div class="dropdown-center">
            <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
              Switch
            </button>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#">Switch Linear</a></li>
              <li><a class="dropdown-item" href="#">Switch Tactile</a></li>
              <li><a class="dropdown-item" href="#">Switch Clicky</a></li>
              <li><a class="dropdown-item" href="#">Switch Silent</a></li>
              <li><a class="dropdown-item" href="#">Stab Switch</a></li>
            </ul>
          </div>
          <div class="dropdown-center">
            <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
              PreBuild
            </button>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#">Full Size</a></li>
              <li><a class="dropdown-item" href="#">TKL</a></li>
              <li><a class="dropdown-item" href="#">75% or less</a></li>
              <li><a class="dropdown-item" href="#">Alice</a></li>
              <li><a class="dropdown-item" href="#">HHKB</a></li>
            </ul>
          </div>
          <div class="dropdown-center">
            <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
              Modding
            </button>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#">Kit modding</a></li>
              <li><a class="dropdown-item" href="#">Switch modding</a></li>
              <li><a class="dropdown-item" href="#">Stabilizer modding</a></li>
            </ul>
          </div>
        </div>

        <section>
          <div class="container pt-3">
            <button class="btn d-md-none" type="button" style="border: 2px solid black; border-top: none; border-left: none; border-right: none; border-radius: 0%; padding-left: 15px;" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions">
              Category
              <i class="bi bi-chevron-compact-right"></i>
            </button>
            <div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions">
              <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasWithBothOptionsLabel">Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
              </div>
              <div class="offcanvas-body">
                <div class="accordion accordion-flush" id="accordionFlushExample">
                  <div class="accordion-item">
                    <h2 class="accordion-header">
                      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne">
                        Keyboard Kit
                      </button>
                    </h2>
                    <div id="flush-collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                      <div class="accordion-body d-block m-0 p-0">
                        <button class="btn">Full Size</button> 
                      </div>
                      <div class="accordion-body d-block m-0 p-0">
                        <button class="btn">TKL</button>
                      </div>
                      <div class="accordion-body d-block m-0 p-0">
                        <button class="btn">75% or less</button>
                      </div>
                      <div class="accordion-body d-block m-0 p-0">
                        <button class="btn">Alice</button>
                      </div>
                      <div class="accordion-body d-block m-0 p-0">
                        <button class="btn">HHKB</button>
                      </div>
                    </div>
                  </div>
                  <div class="accordion-item">
                    <h2 class="accordion-header">
                      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo">
                        Accordion Item #2
                      </button>
                    </h2>
                    <div id="flush-collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                      <div class="accordion-body">Placeholder content for this accordion, which is intended to demonstrate the <code>.accordion-flush</code> class. This is the second item's accordion body. Let's imagine this being filled with some actual content.</div>
                    </div>
                  </div>
                  <div class="accordion-item">
                    <h2 class="accordion-header">
                      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree">
                        Accordion Item #3
                      </button>
                    </h2>
                    <div id="flush-collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                      <div class="accordion-body">Placeholder content for this accordion, which is intended to demonstrate the <code>.accordion-flush</code> class. This is the third item's accordion body. Nothing more exciting happening here in terms of content, but just filling up the space to make it look, at least at first glance, a bit more representative of how this would look in a real-world application.</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section> -->
        
        <div>
            <?php
                include($page_path);
            ?>
        </div>
    </main>
    

    

    

    <script src="js/header_script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
  </body>
</html>

<?php
include("component/footer.html")
?>

