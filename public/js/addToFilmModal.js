const modal = document.querySelector("#myModal");
const openBtns = document.querySelectorAll(".addToFilmOpenModal");
const closeBtn = document.querySelector(".close-btn");
const title = document.querySelector("#modalTitle");
const searchInput = document.querySelector("#modalSearch");
const searchResults = document.querySelector("#searchResults");
const id_film = document.querySelector(".modal-content").firstElementChild.id.replace("filmID", "");

let entity = "";

function escapeHTML(str) {
    return str
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}


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
                    const newPerson = document.createElement("div");
                    if (entity === "Actor") {
                        newPerson.setAttribute("id", `actor-${escapeHTML(actor.id_actor)}`);
                        newPerson.classList.add("col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2 mb-4 d-flex justify-content-center");
                        newPerson.innerHTML =
                            `<div style="width: 155px;">
                                <a href="index.php?controller=Actor&action=details&id_actor=${escapeHTML(data.actor.id_actor)}"
                                    class="darkTypo menuLinks">
                                    <div style="width: 155px">
                                        <object data="img/img_actors/${escapeHTML(data.actor.picture)}"
                                            class="img-fluid rounded shadow-sm" alt="${escapeHTML(data.actor.name)}"
                                            style="width: 155px">
                                            <img src="img/nopicture.jpg" class="img-fluid rounded shadow-sm mb-1" alt="no picture" style="width: 155px">
                                        </object>
                                        <p class="text-center fw-bold mt-1 mb-0">${escapeHTML(data.actor.name)}<i></i></p>
                                    </div>
                                </a>
                                <?php if (isset($_SESSION["user"]) && $_SESSION["user"]["type"] === "admin") { ?>
                                    <a id="removeActor-${escapeHTML(data.actor.id_actor)}"
                                        href="#" class="text-center btnRemoveFromFilm btn btn-danger mt-2" style="width: 155px">
                                        Retirer du film
                                    </a>
                                <?php
                                } ?>
                             </div>`;
                    }
                    if (entity === 'Director') {
                        newPerson.setAttribute("id", `director-${escapeHTML(director.id_director)}`);
                        newPerson.classList.add("mb-4 mx-4");
                        newPerson.innerHTML =
                            `<a href="index.php?controller=Director&action=details&id_director=${escapeHTML(data.director.id_director)}"
                                 class="darkTypo menuLinks">
                                 <div class="me-5" style="width: 155px">
                                     <object data="img/img_directors/${escapeHTML(data.director.picture)}"
                                         class="img-fluid rounded shadow-sm" alt="${escapeHTML(data.director.name)}"
                                         style="width: 155px">
                                         <img src="img/nopicture.jpg" class="img-fluid rounded shadow-sm mb-1" alt="no picture" style="width: 155px">
                                     </object>
                                     <p class="text-center fw-bold mt-1 mb-0">${escapeHTML(data.director.name)}</p>
                                 </div>
                             </a>
                             <?php if (isset($_SESSION["user"]) && $_SESSION["user"]["type"] === "admin") { ?>
                                 <!-- ADMIN CONNECTE : Bouton retirer réalisateur du film -->
                                 <a id="removeDirector-${escapeHTML(data.director.id_director)}"
                                     href="#" class="text-center btnRemoveFromFilm btn btn-danger mt-2" style="width: 155px">
                                     Retirer du film
                                 </a>
                             <?php
                             } ?>`;
                    }
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
