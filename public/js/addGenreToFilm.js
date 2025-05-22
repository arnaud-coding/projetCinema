const modal = document.querySelector("#myModal");
const openBtn = document.querySelector(".addGenreToFilmOpenModal");
const closeBtn = document.querySelector(".close-btn");
const validateBtn = document.querySelector(".validate-btn");

// Ouvrir la modale
openBtn.addEventListener("click", function (e) {
    modal.style.display = "flex";
    document.body.classList.add("noscroll"); // ⛔ empêche le scroll du body
})


// Fermer la modale au clic sur le X
closeBtn.addEventListener("click", () => {
    modal.style.display = "none";
    document.body.classList.remove("noscroll"); // ✅ réactive le scroll
});

// Fermer la modale après validation sélection
validateBtn.addEventListener("click", () => {
    modal.style.display = "none";
    document.body.classList.remove("noscroll"); // ✅ réactive le scroll
});

// Fermer si on clique en dehors de la modale
window.addEventListener("click", (e) => {
    if (e.target === modal) {
        modal.style.display = "none";
        document.body.classList.remove("noscroll"); // ✅ réactive le scroll
    }
});