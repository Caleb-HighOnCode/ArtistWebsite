// Optional: Add animation to cards on page load
document.addEventListener("DOMContentLoaded", function () {
  document.querySelectorAll(".art-card").forEach((card, index) => {
    setTimeout(() => {
      card.style.opacity = "1";
      card.style.transform = "translateY(0)";
    }, index * 200);
  });

  var elem;

  // Use event delegation for .item click handler
  $(document).on("click", ".item", function () {
    var elem = $(this);

    var productName = elem.find(".art-title").text();
    var productPrice = elem.find(".product-price-only").text();
    var productDesc = elem.find(".description").text();

    popup.classList.add("artwork-popup--active");
    document.body.style.overflow = "hidden";

    // Data popup
    $(".artwork-popup__main-image .image").css(
      "background-image",
      "url(" + elem.find("img").attr("src") + ")"
    );

    $(".artwork-popup__title").text(productName);
    $(".artwork-popup__price-section .artwork-popup__price").text(productPrice);
    $(".artwork-popup__description").text(productDesc);
  });
});

function closePopupProduct() {
  popup.classList.remove("artwork-popup--active");
  document.body.style.overflow = "auto";
}

const popup = document.getElementById("popup");

popup.addEventListener("click", (e) => {
  if (e.target === popup) {
    closePopupProduct();
  }
});
