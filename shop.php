<?php
session_start();
include './admin_php/config.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Shop Original Paintings by Augustine Devotta - Best Artist in Chennai</title>
  <meta name="description"
    content="Buy original paintings by Augustine Devotta, the best painting artist in Chennai. Own a masterpiece and bring artistry into your life.">
  <meta name="keywords"
    content="Shop paintings Chennai, Augustine Devotta art for sale, Original artwork Chennai, Buy paintings by Augustine Devotta, Chennai art shop">
  <link rel="icon" href="./img/logo.png" type="image/x-icon" />

  <!-- Required meta tags -->
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

  <link rel="stylesheet" href="./css/styles.css" />
  <link rel="stylesheet" href="./css/index.css" />
  <link rel="stylesheet" href="./css/home.css" />
  <link rel="stylesheet" href="./css/about.css" />
  <link rel="stylesheet" href="./css/works.css" />
</head>

<body>
  <?php include 'subheader.php' ?>

  <section class="hero landing-screen d-flex align-items-center">
    <div class="container-fluid position-relative">
      <div class="row align-items-center">
        <!-- Left Content -->
        <div class="col-lg-6 order-1">
          <div>
            <div class="d-flex align-items-center mb-4">
              <div class="me-3">
                <i class="fas fa-palette text-purple-500 me-2"></i>
                <i class="fas fa-camera text-blue-500 me-2"></i>
                <i class="fas fa-pen-nib text-pink-500"></i>
              </div>
              <span class="text-gray-400">Shop The Creativity</span>
            </div>
          </div>

          <div>
            <h1 class="display-4 fw-bold mb-4">
              Own The
              <span class="gradient-text">Worth</span>
            </h1>
          </div>

          <div>
            <p class="lead text-gray-300 mb-4">
              Transforming visions into captivating visual experiences through innovative design and photography.
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
                <i class="fas fa-pen-nib text-success me-2"></i>
                <span>100+ Arts</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Right Content - Floating Images -->
        <div class="col-lg-6 order-0 d-none d-lg-block">
          <div class="distortion-container">
            <div id="rgbKineticSlider" class="rgbKineticSlider"></div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <div class="artwork-popup" id="popup">
    <div class="artwork-popup__container">
      <button class="artwork-popup__close" onclick="closePopupProduct()">
        ✕
      </button>
      <div class="artwork-popup__content">
        <div class="artwork-popup__image-section">
          <div class="artwork-popup__main-image">
            <div class="image"></div>
          </div>
        </div>

        <div class="artwork-popup__details">
          <div>
            <h1 class="artwork-popup__title">Ethereal Dreams #1</h1>
            <div class="artwork-popup__tags">
              <span class="artwork-popup__tag">Limited Edition</span>
              <span class="artwork-popup__tag">Art</span>
            </div>
          </div>

          <div class="artwork-popup__price-section">
            <div class="artwork-popup__price d-inline-block">₹4,000</div>
            <span class="artwork-popup__stock artwork-popup__stock--available">In Stock</span>
          </div>

          <p class="artwork-popup__description">
            A masterpiece that captures the essence of human emotion through
            the delicate interplay of light and shadow. This piece represents
            the convergence of traditional artistry with modern digital
            techniques.
          </p>

          <div class="artwork-popup__info">
            <div class="artwork-popup__info-item">
              <span class="artwork-popup__info-label">Created</span>
              <span class="artwork-popup__info-value">2024</span>
            </div>
            <div class="artwork-popup__info-item">
              <span class="artwork-popup__info-label">Edition</span>
              <span class="artwork-popup__info-value">Limited (1 of 10)</span>
            </div>
          </div>

          <button class="artwork-popup__contact">Contact Now</button>
        </div>
      </div>
    </div>
  </div>

  <div class="container-fluid mt-4">
    <div class="row">
      <div class="col">
        <div class="section-title-wrapper mb-4 pt-md-4">
          <h1 class="niconne-regular">Shop Now</h1>
          <h3>MY ARTS</h3>
        </div>

        <div class="shop-grid-container">
          <?php
          // Fetch all project images
          $sql = "SELECT images.image_url, projects.project_name, projects.description, projects.status, projects.price 
                  FROM images 
                  JOIN projects ON images.project_id = projects.project_id 
                  GROUP BY projects.project_name";
          $result = $conn->query($sql);

          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              $image_url = strpos($row['image_url'], '../') === 0 ? substr($row['image_url'], 3) : $row['image_url'];
              $status = $row['status']; // Fetch the status from the query result
              $statusClass = strtolower(str_replace(' ', '-', $status)) === 'out-of-stock' ? 'artwork-popup__stock--unavailable' : 'artwork-popup__stock--available'; // Convert status to a class-friendly format
              ?>
              <div class="item">
                <div class="art-card">
                  <div class="art-card-inner">
                    <div class="image-container">
                      <img src="<?php echo $image_url; ?>" alt="Artist Augustine Devotta" class="art-image" />
                      <div class="image-overlay"></div>
                      <span class="status-badge <?php echo $statusClass ?>">
                        <?php echo htmlspecialchars($status); ?></span>
                    </div>
                    <div class="content-section">
                      <div class="d-flex justify-content-between align-items-start">
                        <div>
                          <h3 class="art-title"><?php echo $row['project_name']; ?></h3>
                          <div class="artist-info mt-2">
                            <span class="artist-icon">
                              <i class="fas fa-brush"></i>
                            </span>
                            Created by Artistic Soul
                          </div>
                        </div>
                      </div>
                      <p class="description">
                        <?php echo $row['description']; ?>
                      </p>
                      <div class="card-footer d-flex justify-content-between align-items-center">
                        <div class="price-display">
                          <span class="price-label-small">Price:</span>
                          <div class="product-price-only d-inline-block">
                            ₹<?php echo $row['price']; ?>
                          </div>
                        </div>
                        <button class="view-button">
                          View
                          <i class="fas fa-arrow-right"></i>
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <?php
            }
          } else {
            echo '<div class="swiper-slide"><p>No images available.</p></div>';
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

  <script src="https://cdn.jsdelivr.net/gh/hmongouachon/rgbKineticSlider/js/libs/TweenMax.min.js"></script>
  <script src="https://cdn.jsdelivr.net/gh/hmongouachon/rgbKineticSlider/js/libs/imagesLoaded.pkgd.min.js"></script>
  <script src="https://cdn.jsdelivr.net/gh/hmongouachon/rgbKineticSlider/js/libs/pixi.min.js"></script>
  <script src="https://cdn.jsdelivr.net/gh/hmongouachon/rgbKineticSlider/js/libs/pixi-filters.min.js"></script>
  <script src="https://cdn.jsdelivr.net/gh/hmongouachon/rgbKineticSlider/js/rgbKineticSlider.js"></script>
  <script src="./js/distortion.js"></script>
  <script src="./js/product-popup.js"></script>

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