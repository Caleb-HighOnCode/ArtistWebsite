<header class="nav-bar-container">
  <div class="container-fluid-max">
    <div class="navigation  d-flex justify-content-between align-items-center">
      <div class="nav-main-wrapper">
        <a href="home">
          <div class="nav-image d-md-block">
            <div class="niconne-regular text-white">Augustine Devotta</div>
          </div>
        </a>

        <div class="nav-link navigation-pages-wrapper d-md-flex align-items-center">
          <nav class="d-md-flex">
            <a class="<?php echo ($_SERVER['REQUEST_URI'] == '/' || substr($_SERVER['REQUEST_URI'], -1) == '/' || basename($_SERVER['REQUEST_URI'], '.php') == 'home' || basename($_SERVER['REQUEST_URI'], '.php') == 'index') ? 'active-nav' : ''; ?>"
              href="home">Home</a>
            <a class="<?php echo basename($_SERVER['REQUEST_URI'], '.php') == 'about' ? 'active-nav' : ''; ?>"
              href="about">About Us</a>
            <a class="<?php echo basename($_SERVER['REQUEST_URI'], '.php') == 'shop' ? 'active-nav' : ''; ?>"
              href="shop">Shop</a>
            <a class="<?php echo basename($_SERVER['REQUEST_URI'], '.php') == 'works' ? 'active-nav' : ''; ?>"
              href="works">Works</a>
          </nav>
        </div>

        <a href="contact">
          <button class="contact-btn">
            Contact Us
            <i class="fas fa-arrow-right contact-icon"></i>
          </button>
        </a>

        <!-- Burger Menu Button -->
        <div class="burger-menu d-md-none" onclick="toggleMenu()">
          <span></span>
          <span></span>
          <span></span>
        </div>
      </div>

      <div class="mobile-nav-wrapper d-md-none">
        <div class="nav-menu-wrapper">
          <div class="flex-column d-flex d-md-none align-items-center">
            <a class="nav-item <?php echo ($_SERVER['REQUEST_URI'] == '/' || substr($_SERVER['REQUEST_URI'], -1) == '/' || basename($_SERVER['REQUEST_URI'], '.php') == 'home' || basename($_SERVER['REQUEST_URI'], '.php') == 'index') ? 'active-nav' : ''; ?>"
              href="home">Home</a>
            <a class="nav-item <?php echo basename($_SERVER['REQUEST_URI'], '.php') == 'about' ? 'active-nav' : ''; ?>"
              href="about">About Us</a>
            <a class="nav-item <?php echo basename($_SERVER['REQUEST_URI'], '.php') == 'shop' ? 'active-nav' : ''; ?>"
              href="shop">Shop</a>
            <a class="nav-item <?php echo basename($_SERVER['REQUEST_URI'], '.php') == 'works' ? 'active-nav' : ''; ?>"
              href="works">Works</a>
            <a class="nav-item <?php echo basename($_SERVER['REQUEST_URI'], '.php') == 'contact' ? 'active-nav' : ''; ?>"
              href="contact">Contact</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</header>