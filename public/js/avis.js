document.addEventListener("DOMContentLoaded", function () {
  const stars = document.querySelectorAll(".star");
  let ratingValue = 0;

  stars.forEach(star => {
    star.addEventListener("mouseover", function () {
      const value = this.getAttribute("data-value");
      highlightStars(value);
    });

    star.addEventListener("mouseout", function () {
      highlightStars(ratingValue);
    });

    star.addEventListener("click", function () {
      ratingValue = this.getAttribute("data-value");
      document.getElementById("rating-value").innerText = `Note : ${ratingValue}/5`;
      document.getElementById("note").value = ratingValue;
    });
  });

  function highlightStars(value) {
    stars.forEach(star => {
      star.classList.toggle("active", star.getAttribute("data-value") <= value);
    });
  }
});