let entity = "";

document.querySelectorAll('.deleteLink').forEach(link => {
    link.addEventListener('click', function (e) {
        e.preventDefault();

        entity = this.dataset.entity;
        const id = this.id.replace(`delete${entity}-`, "");
        const item = this.dataset.item
        // parentDiv uniquement si c’est une critique
        let parentDiv = null;
        if (entity === "Review") {
            parentDiv = document.querySelector(`#${entity.toLowerCase()}-${id}`);
        }

        console.log(parentDiv);
        if (confirm(`Êtes-vous sûr de vouloir supprimer ${item} ?`)) {
            fetch(`index.php?controller=${entity}&action=delete&id_${entity.toLowerCase()}=${id}`, { method: "GET" })
                .then(response => response.json())
                .then(data => {
                    if (data.success === true) {
                        document.getElementById('message').innerHTML =
                            '<p class="text-success">' + data.message + '</p>';

                        if (parentDiv) {
                            parentDiv.remove();
                        } else {
                            // Redirection si besoin
                            window.location.href = data.redirect || "index.php";
                        }
                    } else {
                        document.getElementById('message').innerHTML =
                            '<p class="text-danger">' + data.message + '</p>';
                    }
                })
                .catch(error => {
                    document.getElementById('message').innerHTML =
                        '<p class="text-danger">Une erreur est survenue lors de la suppression.</p>';
                })
        }
    })
})