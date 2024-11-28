const data = [
    {
        id: 1,
        name: "Thomas",
        job: "Graphic Designer",
        img: "./img/user-photo.png",
        text: "I am extremely satisfied with the software services provided by this company. Their team is highly skilled, professional, and efficient. They delivered a top-notch solution that exceeded my expectations. I highly recommend their services to anyone looking for reliable and innovative software development.",
    },
    {
        id: 2,
        name: "Jacob",
        job: "Web Designer",
        img: "./img/user-photo.png",
        text: "I have been using the software developed by this company for a few months now, and I must say that it has been a game-changer for my business. Its user-friendly, robust and highly customizable, making it an ideal solution for my needs. The team has been responsive and supportive throughout the development process, and I'm glad I chose them for this project.",
    },
    {
        id: 3,
        name: "Annie",
        job: "Manager",
        img: "./img/user-photo.png",
        text: "The software services offered by this company are exceptional. They have a deep understanding of the latest technologies and trends, and their solutions are designed to meet the specific needs of their clients. Their team is highly professional, responsive and collaborative, making it easy to work with them. I highly recommend their services to anyone looking for high-quality software solutions.",
    },
    {
        id: 4,
        name: "Daisy",
        job: "CEO",
        img: "./img/user-photo.png",
        text: "Working with this company has been a great experience. Their software development process is well-organized, and they are always open to feedback and suggestions. They have a talented team of developers, designers and project managers who work together to deliver exceptional solutions. I would definitely recommend their services to anyone looking for reliable and innovative software development.",
    },
];

const img = document.querySelector("#pic");
const btnNext = document.querySelector(".btn-right");
const btnPrevious = document.querySelector(".btn-left");
const name = document.querySelector("#name");
const role = document.querySelector("#role");
const text = document.querySelector("#text");
let currentIndex = 0;

window.addEventListener("DOMContentLoaded", function () {
    loadTestimonial(data[currentIndex]);
});

function loadTestimonial(testimonial) {
    img.src = testimonial.img;
    name.textContent = testimonial.name;
    role.textContent = testimonial.job;
    text.textContent = testimonial.text;
}

btnNext.addEventListener("click", function () {
    currentIndex++;
    if (currentIndex > data.length - 1) {
        currentIndex = 0;
    }
    loadTestimonial(data[currentIndex]);
});

btnPrevious.addEventListener("click", function () {
    currentIndex--;
    if (currentIndex < 0) {
        currentIndex = data.length - 1;
    }
    loadTestimonial(data[currentIndex]);
});

setInterval(function () {
    currentIndex++;
    if (currentIndex > data.length - 1) {
        currentIndex = 0;
    }
    loadTestimonial(data[currentIndex]);
}, 3000);
