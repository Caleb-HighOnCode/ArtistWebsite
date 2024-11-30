<?php
session_start();
include './admin_php/config.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Artworks by Augustine Devotta - Masterpieces by the Best Artist in Chennai</title>
  <meta name="description"
    content="Explore the stunning artworks of Augustine Devotta, the best painting artist in Chennai. View his collection of masterpieces that inspire and captivate.">
  <meta name="keywords"
    content="Augustine Devotta artworks, Best paintings in Chennai, Stunning art collection, Masterpieces by Chennai artist, Artistic creations in Chennai">
  <link rel="icon" href="./img/logo.png" type="image/x-icon" />

  <!-- Required meta tags -->
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" />
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

  <link rel="stylesheet" href="./css/styles.css" />
  <link rel="stylesheet" href="./css/index.css" />
  <link rel="stylesheet" href="./css/home.css" />
  <link rel="stylesheet" href="./css/about.css" />
  <link rel="stylesheet" href="./css/works.css" />
</head>

<body>
  <?php include 'subheader.php' ?>

  <!-- Hero Section -->
  <section class="hero d-flex align-items-center">
    <div class="container-fluid position-relative">
      <div class="row align-items-center">
        <!-- Left Content -->
        <div class="col-lg-6">
          <div>
            <div class="d-flex align-items-center mb-4">
              <div class="me-3">
                <i class="fas fa-palette text-purple-500 me-2"></i>
                <i class="fas fa-camera text-blue-500 me-2"></i>
                <i class="fas fa-pen-nib text-pink-500"></i>
              </div>
              <span class="text-gray-400">Artfolio</span>
            </div>
          </div>

          <div>
            <h1 class="display-4 fw-bold mb-4">
              My Best
              <span class="gradient-text">Paintings</span>
            </h1>
          </div>

          <div>
            <p class="lead text-gray-300 mb-4">
              Transforming ideas into captivating visual treat by my brush strokes
            </p>
          </div>

          <div class="d-flex gap-3 mb-5">
            <div class="d-flex align-items-center justify-content-center mt-2">
              <a href="contact" class="">
                <button class="view-button">
                  Connect Now
                  <i class="fas fa-arrow-right"></i>
                </button>
              </a>
            </div>
          </div>

          <div>
            <div class="d-flex flex-wrap gap-4 text-gray-400">
              <div class="d-flex align-items-center">
                <i class="fas fa-award text-warning me-2"></i>
                <span>Accolades</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Right Content - Floating Images -->
        <div class="col-lg-6">
          <div class="floating-images">
            <div class="bg-gradient-1"></div>
            <div class="bg-gradient-2"></div>

            <div class="floating-image float-1">
              <img src="img/mid/d.png" alt="Creative Work 1">
            </div>
            <div class="floating-image float-2">
              <img src="img/mid/b.png" alt="Creative Work 2">
            </div>
            <div class="floating-image float-3">
              <img src="img/mid/q.png" alt="Creative Work 3">
            </div>
            <div class="floating-image float-4">
              <img src="img/mid/1.png" alt="Creative Work 4">
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <div class="container-fluid">
    <div class="row">
      <div class="col">
        <div class="section-title-wrapper mt-5 pt-md-4">
          <h1 class="niconne-regular">Gallery Of</h1>
          <h3>MY ARTS</h3>
        </div>
        <div class="gallery-container mt-5">
          <?php
          // Fetch all project images
          $imageSql = "SELECT imageUrl FROM landing_page";
          $resultImages = $conn->query($imageSql);

          if ($resultImages->num_rows > 0) {
            while ($row = $resultImages->fetch_assoc()) {
              $imageUrl = strpos($row['imageUrl'], '../') === 0 ? substr($row['imageUrl'], 3) : $row['imageUrl'];
              ?>
              <div class="gallery-card">
                <div class="gallery-card-image">
                  <a href="<?php echo $imageUrl; ?>" data-fancybox="gallery">
                    <i class="icon-zoom-in"></i>
                    <img src="<?php echo $imageUrl; ?>" alt="Augustine Devotta Arts" />
                  </a>
                </div>
              </div>
              <?php
            }
          } else {
            echo '<div class=""></div>';
          } ?>
        </div>
      </div>
    </div>
  </div>

  <?php include 'footer.php' ?>

  <script src="js/jQuery.js"></script>
  <!-- Swiper JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
  <script src="js/landing-page-anim.js"></script>
  <script src="js/gallery.js"></script>
  <script src="js/footer.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
    crossorigin="anonymous"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
    integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
    crossorigin="anonymous"></script>

  <script>
    function toggleMenu() {
      const mobileNav = document.querySelector(".mobile-nav-wrapper");
      const burgerMenu = document.querySelector(".burger-menu");
      mobileNav.classList.toggle("active");
      burgerMenu.classList.toggle("active");
    }
  </script>
</body>

</html>