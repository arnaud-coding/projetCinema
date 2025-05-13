<!--------------------->
<!-- PAGE D'ACCUEIL -->
<!--------------------->
<?php
$user = isset($_SESSION["user"]) ? $_SESSION["user"] : null;
?>
<div class="d-flex flex-column justify-content-center align-items-center">
    <?php if ($user) { ?>
        <!-- USER OU ADMIN CONNECTE -->
        <h1 class="fs-3 fst-italic mb-3">Bienvenue <?php echo htmlspecialchars($user["pseudo"], ENT_QUOTES, "UTF-8") ?> !</h1>
    <?php
    } else { ?>
        <!-- AUCUN UTILISATEUR CONNECTE -->
        <h1 class="fs-3 fst-italic mb-3">Bienvenue sur MovieLovers !</h1>
        <p>
            Rejoignez-nous en vous créant un compte,
            <br>ou connectez vous si vous avez déja un compte...
        </p>
    <?php
    } ?>
</div