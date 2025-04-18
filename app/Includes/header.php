<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="img/png" href="img/logo.png">
    <title>MovieLovers</title>

    <!-- CSS Bootstrap -->
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="../public/css/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"> -->
    <link rel="stylesheet" href="../public/icons/bootstrap-icons.min.css">

    <!-- CSS perso -->
    <link rel="stylesheet" href="../public/css/style.css">

    <!-- JS Bootstrap -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script> -->
    <script src="../public/js/bootstrap.bundle.min.js" defer></script>
</head>

<body>
    <header class="border-bottom shadow-sm">
        <!-- BARRE DE NAVIGATION -->
        <nav class="navbar navbar-expand-md bg-white py-3">
            <div class="container">

                <!-- LOGO -->
                <a class="navbar-brand fs-2 fw-bold text-dark" href="index.php">
                    <img src="img/nopicture.jpg" alt="Logo" width="100" height="100">
                    MovieLovers
                </a>

                <!-- MODE CLAIR/OMBRE -->
                <i id="btnModeDark" class="bi bi-lightbulb-fill text-warning ps-4" style="cursor: pointer;"></i>

                <!-- MENU -->
                <!-- <div id="navbarNav" class="collapse navbar-collapse justify-content-center">
                    <ul class="navbar-nav fs-5 fw-semibold">
                        <li class="nav-item">
                            <a class="nav_main nav-link text-dark" href="index.php?controller=Produits&action=">Nos coups de ❤️</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav_main nav-link text-dark" href="index.php?controller=Livre&action=list">Contact</a>
                        </li>
                    </ul>
                </div> -->

                <!-- CHAMP DE RECHERCHE -->
                <form class="d-flex me-4" method="post" action="index.php?controller=Produit&action=search">
                    <input class="form-control me-2 border-secondary" type="text" name="search" placeholder="Rechercher un produit" aria-label="Search">
                    <button class="btn btn-outline-dark" type="submit"><span class="bi bi-search"></span></button>
                </form>

                <!-- BOUTON DE CONNEXION OU MENU UTILISATEUR ET BOUTON PANIER-->
                <?php if (!isset($_SESSION["user"]["id_client"])) : ?>
                    <a class="btn btn-dark text-white px-4 py-2" href="index.php?controller=User&action=formSignup">S'inscrire</a>
                    <a class="btn btn-dark text-white px-4 py-2" href="index.php?controller=User&action=formLogin">Se connecter</a>
                <?php else : ?>
                    <div class="dropdown">
                        <button id="dropdownMenuButton" class="btn btn-dark text-white dropdown-toggle px-4 py-2" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <?php echo htmlspecialchars($_SESSION["user"]["firstname"], ENT_QUOTES, "UTF-8"); ?>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item text-dark" href="index.php?controller=Client&action=formUpdate&id_client=<?php echo htmlspecialchars($_SESSION["user"]["id_client"], ENT_QUOTES, "UTF-8"); ?>">Mon profil</a></li>
                            <li><a class="dropdown-item text-dark" href="index.php?controller=Client&action=logout">Se déconnecter</a></li>
                        </ul>
                    </div>
                    <a class="btn btn-outline-dark ms-2 px-4 py-2" href="index.php?controller=Client&action=displayCart">Panier</a>
                <?php endif; ?>

                <!-- BOUTON RESPONSIVE -->
                <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </nav>

        <!-- NAV : CATEGORIES DE PRODUITS -->
        <nav class="navbar navbar-expand-md bg-white py-4 border-top">
            <div class="container">
                <div id="navbarCat" class="collapse navbar-collapse justify-content-center">
                    <ul class="navbar-nav fs-5 fw-medium">
                        <li class="nav-item"><a class="nav_cat nav-link text-dark" href="index.php?controller=Produit&action=listByCategory&id_categorie=1">Audio</a></li>
                        <li class="nav-item"><a class="nav_cat nav-link text-dark" href="index.php?controller=Produit&action=listByCategory&id_categorie=2">Téléphone</a></li>
                        <li class="nav-item"><a class="nav_cat nav-link text-dark" href="index.php?controller=Produit&action=listByCategory&id_categorie=3">PC portable</a></li>
                        <li class="nav-item"><a class="nav_cat nav-link text-dark" href="index.php?controller=Produit&action=listByCategory&id_categorie=4">PC de bureau</a></li>
                        <li class="nav-item"><a class="nav_cat nav-link text-dark" href="index.php?controller=Produit&action=listByCategory&id_categorie=5">Télévision</a></li>
                    </ul>
                </div>

                <!-- BOUTON RESPONSIVE -->
                <button class="navbar-toggler my-3 border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCat" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
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