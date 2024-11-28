window.addEventListener("scroll", () => {
  // Select all elements with the class 'project-right'
  let elements = document.querySelectorAll(".project-right");

  elements.forEach((element) => {
    const elementRect = element.getBoundingClientRect();
    if (elementRect.top < window.innerHeight && window.innerWidth > 768) {
      const reducedHeight = window.innerHeight - elementRect.top;
      const translateValue = (reducedHeight / window.innerHeight) * 80;
      element.style.transform = `translateY(-${Math.min(
        100,
        translateValue
      )}px)`;
    }
  });
});
