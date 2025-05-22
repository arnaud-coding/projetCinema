const modal = document.querySelector("#myModal");
const openBtns = document.querySelectorAll(".addToFilmOpenModal");
const closeBtn = document.querySelector(".close-btn");
const title = document.querySelector("#modalTitle");
const searchInput = document.querySelector("#modalSearch");
const searchResults = document.querySelector("#searchResults");
const id_film = document.querySelector(".modal-content").firstElementChild.id.replace("filmID", "");

let entity = "";

// OUVERTURE DE LA MODALE
openBtns.forEach(btn => {
    btn.addEventListener("click", function () {
        modal.style.display = "flex";
        document.body.classList.add("noscroll");

        // Détection de l'entité recherchée
        if (this.id === "addActor") {
            entity = "Actor";
            title.textContent = "Ajouter acteur";
            searchInput.setAttribute("placeholder", "Rechercher un acteur");
        } else if (this.id === "addDirector") {
            entity = "Director";
            title.textContent = "Ajouter réalisateur";
            searchInput.setAttribute("placeholder", "Rechercher un réalisateur");
        }

        searchInput.value = "";
        searchResults.innerHTML = "";
        document.querySelector('#resultMsg').innerHTML = "";
        searchInput.focus();
    });
});

// FERMETURE DE LA MODALE
function closeModal() {
    modal.style.display = "none";
    document.body.classList.remove("noscroll");
    searchResults.innerHTML = "";
    searchInput.value = "";
    document.querySelector('#resultMsg').innerHTML = "";
    entity = "";
}

closeBtn.addEventListener("click", closeModal);
window.addEventListener("click", (e) => {
    if (e.target === modal) closeModal();
});

// DELEGATION SUR LES BOUTONS "AJOUTER"
searchResults.addEventListener("click", function (e) {
    if (e.target && e.target.classList.contains("btnAddToFilm")) {
        const btn = e.target;
        const id = btn.id.replace(entity.toLowerCase(), "");

        fetch(`index.php?controller=Film&action=add${entity}ToFilm&id_film=${id_film}&id_${entity.toLowerCase()}=${id}`, {
            method: "GET"
        })
            .then(response => response.json())
            .then(data => {
                if (data.success === true) {
                    document.querySelector(`#${entity.toLowerCase() + id}Li`).remove();
                    document.querySelector('#resultMsg').innerHTML =
                        '<p class="text-success">' + data.message + '</p>';
                } else {
                    document.querySelector('#resultMsg').innerHTML =
                        '<p class="text-danger">' + data.message + '</p>';
                }
            })
            .catch(error => {
                document.querySelector('#resultMsg').innerHTML =
                    '<p class="text-danger">Une erreur est survenue lors de l\'ajout</p>';
            });
    }
});

// RECHERCHE EN DIRECT
let searchTimeout;
searchInput.addEventListener("input", function () {
    clearTimeout(searchTimeout); // évite les appels trop rapides
    const query = this.value.trim();

    if (query.length < 2) {
        searchResults.innerHTML = "";
        return;
    }

    searchTimeout = setTimeout(async () => {
        try {
            const response = await fetch(`index.php?controller=${entity}&action=search&query=${encodeURIComponent(query)}`);
            const data = await response.json();

            searchResults.innerHTML = ""; // nettoyage précédent

            if (data.length === 0) {
                searchResults.innerHTML = "<li>Aucun résultat</li>";
                return;
            }

            data.forEach(person => {
                const li = document.createElement("li");
                li.id = `${entity.toLowerCase()}${person.id}Li`;
                li.className = "text-end my-3";
                li.innerHTML = `<b>${person.name}</b>
                    <button type="button" id="${entity.toLowerCase() + person.id}" class="btnAddToFilm darkBtn btnWithBorders ms-2 p-1">Ajouter</button>`;
                searchResults.appendChild(li);
            });
        } catch (error) {
            searchResults.innerHTML = "<p class='text-danger'>Erreur lors de la recherche</p>";
        }
    }, 300); // délai pour éviter les appels trop fréquents
});