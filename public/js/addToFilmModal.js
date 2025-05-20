const modal = document.querySelector("#myModal");
const openBtn = document.querySelectorAll(".addToFilmopenModal");
const closeBtn = document.querySelector(".close-btn");
const title = document.querySelector("#modalTitle");
const searchInput = document.querySelector("#modalSearch");
const btnSearch = document.querySelector("#btnSearch");
const searchResults = document.querySelector("#searchResults");
const btnAddToFilm = document.querySelectorAll(".btnAddToFilm");
const id_film = document.querySelector(".modal-content").firstElementChild.id.replace("filmID", "");
let entity;
let subject;

// Ouverture modal et affichage resultats recherche acteurs/réalisateurs
openBtn.forEach(btn => {
    btn.addEventListener("click", function (e) {
        // Ouvrir la modale
        modal.style.display = "flex";
        document.body.classList.add("noscroll"); // ⛔ empêche le scroll du body

        // Changement du contenu de la modale
        if (this.id === "addActor") {
            entity = "Actor";
            title.textContent = "Ajouter acteur";
            searchInput.setAttribute("placeholder", "Rechercher un acteur");
        } else if (this.id === "addDirector") {
            entity = "Director";
            title.textContent = "Ajouter réalisateur";
            searchInput.setAttribute("placeholder", "Rechercher un réalisateur");
        }

        // Ecouteur d'évenements sur la barre de recherche et recherche AJAX
        if (!btnSearch.dataset.listenerAdded) {
            btnSearch.addEventListener("click", async () => {
                const query = searchInput.value;

                if (query.length > 2) { // facultatif : on évite les requêtes trop courtes
                    try {
                        const response = await fetch(`index.php?controller=${entity}&action=search&query=${query}`);
                        const data = await response.json();
                        data.forEach(person => {
                            const li = document.createElement("li");
                            li.innerHTML = `<li id='${entity.toLowerCase() + person.id}Li' class='text-end my-3'><b>${person.name}</b><a href='#' id='${entity.toLowerCase() + person.id}' class='btnAddToFilm darkBtn btnWithBorders ms-2 p-1'>Ajouter</a></li>`;
                            searchResults.appendChild(li);
                            console.log(" btnAddToFilm:", btnAddToFilm);
                        });
                    } catch (error) {
                        searchResults.innerHTML = "<p>Erreur lors de la recherche</p>";
                    }
                } else {
                    searchResults.innerHTML = ""; // Vide les résultats si l'entrée est trop courte
                }
            });

            btnSearch.dataset.listenerAdded = "true"; // Pour ne pas ajouter plusieurs fois
        }
    });
});

// Fermer la modale au clic sur le X
closeBtn.addEventListener("click", () => {
    modal.style.display = "none";
    document.body.classList.remove("noscroll"); // ✅ réactive le scroll
    searchResults.innerHTML = "";
    searchInput.value = "";
    entity = "";
});

// Fermer si on clique en dehors de la modale
window.addEventListener("click", (e) => {
    if (e.target === modal) {
        modal.style.display = "none";
        document.body.classList.remove("noscroll"); // ✅ réactive le scroll
        searchResults.innerHTML = "";
        searchInput.value = "";
        entity = ""
    }
});


// Ajout au film apres clic sur acteur/réalisateur et si confirmation
btnAddToFilm.forEach(btn => {
    btn.addEventListener("click", function (e) {
        e.preventDefault();
        if (this.id.startsWith("actor")) {
            id = this.id.replace("actor", "");
            entity = "Actor";
        } else if (this.id.startsWith("director")) {
            id = this.id.replace("director", "");
            entity = "Director";
        }
        fetch(`index.php?controller=Film&action=add${entity}ToFilm&id_film=${id_film}&id_${entity.toLowerCase()}=${id}`, { method: "GET" })
            .then(response => response.json())
            .then(data => {
                if (data.success === true) {
                    console.log("data success");
                    document.querySelector(`#${entity.toLowerCase() + person.id}Li`).remove();
                    document.querySelector('#resultMsg').innerHTML =
                        '<p class="text-success">' + data.message + '</p>';
                } else {
                    document.querySelector('#resultMsg').innerHTML =
                        '<p class="text-danger">' + data.message + '</p>';
                }
            })
            .catch(error => {
                document.querySelector('#resultMsg').innerHTML =
                    '<p class="text-danger">Une erreur est survenue lors de l"ajout</p>';
            });
    });
});
