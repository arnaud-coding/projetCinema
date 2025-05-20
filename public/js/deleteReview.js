document.querySelectorAll('.deleteLink').forEach(link => {
    link.addEventListener('click', function (e) {
        e.preventDefault();
        const reviewId = this.id;
        const reviewDiv = document.querySelector(`#review-${reviewId}`);

        if (confirm('Êtes-vous sûr de vouloir supprimer cette critique ?')) {
            fetch(`index.php?controller=Review&action=delete&id_review=${reviewId}`, { method: "GET" })
                .then(response => response.json())
                .then(data => {
                    if (data.success === true) {
                        reviewDiv.remove();
                        document.getElementById('message').innerHTML =
                            '<p class="text-success">' + data.message + '</p>';
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