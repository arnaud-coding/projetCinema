<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="img/png" href="img/logo.png">
    <title>MovieLovers</title>
    <link rel="stylesheet" href="../public/css/bootstrap.min.css">
    <link rel="stylesheet" href="../public/icons/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../public/css/style.css">
    <script src="https://kit.fontawesome.com/421fcfdcfb.js" crossorigin="anonymous" defer></script>
    <script src="../public/js/bootstrap.bundle.min.js" defer></script>
    <!-- SCRIPTS GLOBAUX -->
    <script src="../public/js/main.js" defer></script>
</head>

<body>
    <header class="border-bottom shadow-sm">
        <!-- BARRE DE NAVIGATION -->
        <nav class="navbar navbar-expand-md pt-3">
            <div class="container">

                <!-- BOUTON MENU BURGER -->
                <button class="navbar-toggler my-3 border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCat" aria-controls="navbarCat" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- LOGO -->
                <a class="navbar-brand fs-2 fw-bold" href="index.php">
                    <img src="img/logo.png" alt="Logo" width="50" height="50">
                    <i class="darkTypo menuLinks">MovieLovers</i>
                </a>

                <!-- CHAMP DE RECHERCHE -->
                <form class="d-flex me-3" method="post" action="index.php?controller=Produit&action=search" style="width: 410px;">
                    <input class="form-control me-2 border-secondary" type="text" name="search" placeholder="Rechercher un film, un acteur ou un réalisateur" aria-label="Search">
                    <button class="btn btn-outline-dark buttonLinks" type="submit"><span class="bi bi-search buttonLinks"></span></button>
                </form>

                <!-- BOUTON DE CONNEXION OU MENU UTILISATEUR -->
                <div class="dropdown">
                    <button class="btn darkBtn profileBtn dropdown-toggle px-4 py-2" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <?php
                        if (isset($_SESSION["user"])) {
                            echo htmlspecialchars($_SESSION["user"]["pseudo"], ENT_QUOTES, "UTF-8");
                            if ($_SESSION["user"]["type"] === "admin") {
                                echo " (admin)";
                            }
                        } else {
                            echo "Mon compte";
                        }
                        ?>
                    </button>
                    <ul class="dropdown-menu">
                        <?php if (!isset($_SESSION["user"])) : ?>
                            <li><a class="dropdown-item text-dark" href="index.php?controller=User&action=formLogin">Se connecter</a></li>
                            <li><a class="dropdown-item text-dark" href="index.php?controller=User&action=formSignup">Créer un compte</a></li>
                        <?php else : ?>
                            <li><a class="dropdown-item text-dark" href="index.php?controller=User&action=formUpdate&id_user=<?php echo htmlspecialchars($_SESSION["user"]["id_user"], ENT_QUOTES, "UTF-8"); ?>">Modifier mon profil</a></li>
                            <li><a class="dropdown-item text-dark" href="index.php?controller=User&action=logout">Se déconnecter</a></li>
                        <?php endif; ?>
                    </ul>
                </div>

                <!-- MODE CLAIR/SOMBRE -->
                <i id="btnModeDark" class="bi bi-moon-fill text-dark fs-3 me-3" style="cursor: pointer;"></i>

            </div>
        </nav>

        <!-- NAV : CATEGORIES -->
        <nav class="navbar navbar-expand-md mb-2">
            <div class="container">
                <div id="navbarCat" class="collapse navbar-collapse justify-content-center">
                    <ul class="navbar-nav fs-5 fw-medium">
                        <li class="nav-item"><a class="nav-link menuLinks darkTypo nav_cat" href="index.php?controller=Produit&action=listByCategory&id_categorie=1">Audio</a></li>
                        <li class="nav-item"><a class="nav-link menuLinks darkTypo nav_cat" href="index.php?controller=Produit&action=listByCategory&id_categorie=2">Téléphone</a></li>
                        <li class="nav-item"><a class="nav-link menuLinks darkTypo nav_cat" href="index.php?controller=Produit&action=listByCategory&id_categorie=3">PC portable</a></li>
                        <li class="nav-item"><a class="nav-link menuLinks darkTypo nav_cat" href="index.php?controller=Produit&action=listByCategory&id_categorie=4">PC de bureau</a></li>
                        <li class="nav-item"><a class="nav-link menuLinks darkTypo nav_cat" href="index.php?controller=Produit&action=listByCategory&id_categorie=5">Télévision</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>


    <main class="py-3">
        <div class="container">

            <!------------------------------------->
            <!-- POSSIBLE MESSAGE D'INFORMATIONS -->
            <!------------------------------------->
            <?php if ($_GET["msgOK"] ?? null) : ?>
                <div id="message" class="alert alert-success py-2" role="alert">
                    <p class="mb-0"><?php echo htmlspecialchars($_GET["msgOK"], ENT_QUOTES, "UTF-8"); ?></p>
                </div>
            <?php endif;
            if ($_GET["msgKO"] ?? null) : ?>
                <div id="message" class="alert alert-danger py-2" role="alert">
                    <p class="mb-0"><?php echo htmlspecialchars($_GET["msgKO"], ENT_QUOTES, "UTF-8"); ?></p>
                </div>
            <?php endif; ?>