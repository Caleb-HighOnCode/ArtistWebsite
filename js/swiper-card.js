$(document).ready(function(){
  $('.owl-carousel').owlCarousel({
    loop: true,
    margin: 5,
    nav: true,
    autoplay: true,
    autoplayTimeout: 5000,
    autoplayHoverPause: true,
    dots: false,  // Disable pagination (dots)
    responsive: {
      0: {
        items: 1
      },
      500: {
        items: 2
      },
      800: {
        items: 3
      },
      1200: {
        items: 4
      }
    }
  });
});
