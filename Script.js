/* When the user clicks on the button, 
toggle between hiding and showing the dropdown content */
function myFunction() {
  document.getElementById("myDropdown").classList.toggle("show");
}

// Close the dropdown if the user clicks outside of it
window.onclick = function(e) {
  if (!e.target.matches('.dropbtn')) {
  var myDropdown = document.getElementById("myDropdown");
    if (myDropdown.classList.contains('show')) {
      myDropdown.classList.remove('show');
    }
  }
}

let slideIndex = 0;
const slides = document.querySelectorAll(".mySlides");
const totalSlides = slides.length;

// Initialize slideshow
function showSlides(n) {
    // Reset all slides to hidden
    slides.forEach((slide) => (slide.style.display = "none"));
    
    // Normalize the index to loop slides correctly
    slideIndex = (n + totalSlides) % totalSlides; // Ensures no negative index
    
    // Show the current slide
    slides[slideIndex].style.display = "block";
}

// Change slides (next/prev)
function changeSlide(n) {
    showSlides(slideIndex + n);
}

// Auto-scroll functionality
function autoScrollSlides() {
    changeSlide(1); // Move to the next slide
    setTimeout(autoScrollSlides, 5000); // Adjust timing as needed (5000ms = 5 seconds)
}

// Add event listeners for manual control
document.querySelector(".prev").addEventListener("click", function () {
    changeSlide(-1);
});

document.querySelector(".next").addEventListener("click", function () {
    changeSlide(1);
});

// Start slideshow
showSlides(slideIndex);
setTimeout(autoScrollSlides, 5000);