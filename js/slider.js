document.addEventListener("DOMContentLoaded", () => {
    const tabsBox = document.querySelector(".tabs-box");

    // Clone the list items and append to create a continuous effect
    const items = tabsBox.innerHTML;
    tabsBox.innerHTML += items;

    // Adjust the width of the container dynamically
    const updateWidth = () => {
        const tabWidth = document.querySelector(".tab").offsetWidth;
        const totalTabs = document.querySelectorAll(".tab").length;
        tabsBox.style.width = `${tabWidth * totalTabs * 2}px`; // Double the total width
    };

    // Initial width adjustment
    updateWidth();

    // Adjust on window resize
    window.addEventListener("resize", updateWidth);
});