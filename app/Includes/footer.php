<!-- POPUP COOKIE -->
<?php include "popUpCookie.php"; ?>

<!-- SCROLL TO TOP BUTTON -->
<button id="arrowScroll" class="position-fixed btn darkBtn btnWithBorders bottom-0 end-0 m-4">
    <i class="bi bi-arrow-up" title="Remonter en haut de la page"></i>
</button>
</div>
</main>

<footer class="border-top text-center py-3">
    <div class="container">
        <p class="mb-0">Suivez nous sur les réseaux sociaux !</p>
        <div class="socialMedias">
            <a href="#"><i class="bi bi-twitter-x linksOnHover darkTypo menuLinks"></i></a>
            <a href="#"><i class="bi bi-facebook px-2 linksOnHover darkTypo menuLinks"></i></a>
            <a href="#"><i class="bi bi-instagram linksOnHover darkTypo menuLinks"></i></a>
        </div>
        <p>&copy; 2025 MovieLovers - Production interne - &reg; Tous droits réservés.</p>
    </div>
</footer>

<!-- SCRIPTS DE LA PAGE
     Chargement dynamique des scripts spécifiques à la page courante -->
<?php if (isset($scripts)) {
    foreach ($scripts as $script) : ?>
        <script <?php echo $script ?>></script>
<?php
    endforeach;
} ?>
</body>

</html>