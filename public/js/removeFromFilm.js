document.querySelectorAll('.btnRemoveFromFilm').forEach(link => {
    link.addEventListener('click', function (e) {
        e.preventDefault();

        let id;
        let parentDiv;
        let id_film;
        let subject;
        let entity;
        if (this.id.startsWith("removeDirector-")) {
            id = this.id.replace("removeDirector-", "");
            parentDiv = document.querySelector(`#director-${id}`);
            id_film = parentDiv.firstElementChild.id.replace("film-", "");
            subject = "ce réalisateur";
            entity = "Director";
        } else if (this.id.startsWith("removeActor-")) {
            id = this.id.replace("removeActor-", "");
            parentDiv = document.querySelector(`#actor-${id}`);
            id_film = parentDiv.firstElementChild.id.replace("film-", "");
            subject = "cet acteur";
            entity = "Actor";
        }

        if (confirm(`Êtes-vous bien sûr de vouloir retirer ${subject} de ce film ?`)) {
            fetch(`index.php?controller=Film&action=remove${entity}FromFilm&id_film=${id_film}&id_${entity.toLowerCase()}=${id}`, { method: "GET" })
                .then(response => response.json())
                .then(data => {
                    if (data.success === true) {
                        parentDiv.remove();
                        document.querySelector('#message').innerHTML =
                            '<p class="text-success">' + data.message + '</p>';
                    } else {
                        document.querySelector('#message').innerHTML =
                            '<p class="text-danger">' + data.message + '</p>';
                    }
                })
                .catch(error => {
                    document.querySelector('#message').innerHTML =
                        '<p class="text-danger">Une erreur est survenue lors de la suppression</p>';
                })
        }
    });
});