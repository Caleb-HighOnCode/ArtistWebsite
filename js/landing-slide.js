const slider = document.querySelector('.slider');
const slides = document.querySelectorAll('.slide');
const totalSlides = slides.length;

// Clone the first and last slide
const firstSlideClone = slides[0].cloneNode(true);
const lastSlideClone = slides[totalSlides - 1].cloneNode(true);

// Add clones to the slider
slider.appendChild(firstSlideClone);
slider.insertBefore(lastSlideClone, slides[0]);

// Update the slides array and totalSlides
const newSlides = document.querySelectorAll('.slide');
const newTotalSlides = newSlides.length;

let currentSlide = 1; // Start from the actual first slide (index 1)
const slideInterval = 3000; // Time between slides in milliseconds

// Initialize the slider position
slider.style.transition = 'none'; // Disable transition for initial setup
slider.style.transform = `translateX(-${currentSlide * 100}%)`;
slider.offsetHeight; // Force reflow to apply initial positioning
slider.style.transition = 'transform 0.5s ease-in-out'; // Re-enable transition

function showSlide(index) {
  slider.style.transform = `translateX(-${index * 100}%)`;

  // Adjust for the cloned slides at the boundaries
  if (index === newTotalSlides - 2) { // if it's the clone of the first slide
    setTimeout(() => {
      slider.style.transition = 'none'; // Disable transition for instant jump
      slider.style.transform = `translateX(-${100}%)`; // Jump to the actual first slide
      slider.offsetHeight; // Force reflow
      slider.style.transition = 'transform 0.5s ease-in-out'; // Re-enable transition
    }, 500); // Match the timeout with the transition duration
    currentSlide = 1; // Reset to the first actual slide
  } else if (index === 0) { // if it's the clone of the last slide
    setTimeout(() => {
      slider.style.transition = 'none'; // Disable transition for instant jump
      slider.style.transform = `translateX(-${(newTotalSlides - 2) * 100}%)`; // Jump to the actual last slide
      slider.offsetHeight; // Force reflow
      slider.style.transition = 'transform 0.5s ease-in-out'; // Re-enable transition
    }, 500); // Match the timeout with the transition duration
    currentSlide = newTotalSlides - 2; // Reset to the last actual slide
  } else {
    currentSlide = index; // Regular slide transition
  }
}

function nextSlide() {
  showSlide(currentSlide + 1);
}

// Automatically move to the next slide every few seconds
setInterval(nextSlide, slideInterval);
