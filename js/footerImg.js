document.addEventListener("DOMContentLoaded", function () {
  const footerImage = document.querySelector(".footer-img");

  window.addEventListener("scroll", function () {
    const footerImageRect = footerImage.getBoundingClientRect();

    // You may still check for conditions if you need further behavior changes
    if (footerImageRect.top <= this.window.innerHeight / 1.1) {
      const minWidthPercentage = 70; // Minimum width in percentage
      const maxWidthPercentage = 100; // Maximum width in percentage
      const minTop = 0;
      const maxTop = this.window.innerHeight;

      // Calculate the width based on the top value
      let newWidthPercentage =
        minWidthPercentage +
        ((maxWidthPercentage - minWidthPercentage) *
          (footerImageRect.top * 2 - minTop)) /
          (maxTop - minTop);

      // Set the calculated width to footerImageRect
      if (newWidthPercentage > 85 && newWidthPercentage <= 100) {
        if(newWidthPercentage > 99) newWidthPercentage = 100;
        footerImage.style.transform = `scale(${newWidthPercentage / 100})`;
        footerImage.style.paddingBottom = `${Math.max(0, 50 - (newWidthPercentage * 2))}px`;
      }
    }
  });
});
