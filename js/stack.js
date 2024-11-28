document.addEventListener("DOMContentLoaded", function () {
  const stepRight = document.querySelector(".step-right");
  const cardDeck = document.querySelector(".scard-deck-js");

  window.addEventListener("scroll", function () {
    const cardDeckRect = cardDeck.getBoundingClientRect();

    // You may still check for conditions if you need further behavior changes
    if (cardDeckRect.top - 100 <= 0) {
      stepRight.style.position = "sticky";
      stepRight.style.top = `100px`;
    } else {
      stepRight.style.position = "relative";
      stepRight.style.top = `0px`;
    }
  });
});
