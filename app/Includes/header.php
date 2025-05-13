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
    <header class="sticky-top lightBg">
        <!-- BARRE DE NAVIGATION PRINCIPALE -->
        <nav class="navbar navbar-expand-md pt-2 pb-0">
            <div class="container flex-nowrap">

                <!-- BOUTON MENU BURGER -->
                <button class="navbar-toggler my-3 lightBg border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCat" aria-controls="navbarCat" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- LOGO -->
                <a class="navbar-brand fs-2 fw-bold ms-3" href="index.php">
                    <img src="img/logo.png" alt="Logo" width="50" height="50">
                    <i class="linksOnHover darkTypo menuLinks d-none d-md-inline">MovieLovers</i>
                </a>

                <!-- CHAMP DE RECHERCHE -->
                <form class="d-flex me-3" method="post" action="index.php?controller=Produit&action=search" style="width: 410px;">
                    <input class="form-control me-2 border-secondary d-none d-lg-inline" type="text" name="search" placeholder="Rechercher un film, un acteur ou un réalisateur" aria-label="Search">
                    <button class="btn btn-outline-dark buttonLinks d-none d-lg-inline" type="submit"><span class="bi bi-search buttonLinks"></span></button>
                </form>

                <!-- MENU CONNEXION USER/ADMIN -->
                <div class="dropdown">
                    <i id="userIcon" class="bi bi-person-fill linksOnHover text-dark d-md-none dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="font-size: 34px; margin-right: 75px"></i>
                    <button class="btn darkBtn btnWithBorders dropdown-toggle d-none d-md-inline px-4 py-2" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <?php if (isset($_SESSION["user"])) {
                            echo htmlspecialchars($_SESSION["user"]["pseudo"], ENT_QUOTES, "UTF-8");
                            if ($_SESSION["user"]["type"] === "admin") {
                                echo " (admin)";
                            }
                        } else {
                            echo "Mon compte";
                        } ?>
                    </button>
                    <ul class="dropdown-menu darkBtn btnWithBorders py-0">
                        <?php if (!isset($_SESSION["user"])) { ?>
                            <!-- AUCUN UTILISATEUR CONNECTE -->
                            <li><a class="dropdown-item dropdownUserBtn darkBtn btnWithBorders" href="index.php?controller=User&action=formLogin">Se connecter</a></li>
                            <li><a class="dropdown-item dropdownUserBtn darkBtn btnWithBorders" href="index.php?controller=User&action=formSignup">Créer un compte</a></li>
                            <?php
                        } else {
                            // UTILISATEUR OU ADMIN CONNECTE
                            if ($_SESSION["user"]["type"] === "admin") { ?>
                                <li><a class="dropdown-item dropdownUserBtn darkBtn btnWithBorders" href="index.php?controller=User&action=formSignup">Créer un compte</a></li>
                            <?php
                            } ?>
                            <li><a class="dropdown-item dropdownUserBtn darkBtn btnWithBorders" href="index.php?controller=User&action=formUpdate&id_user=<?php echo htmlspecialchars($_SESSION["user"]["id_user"], ENT_QUOTES, "UTF-8"); ?>">Modifier mon profil</a></li>
                            <li><a class="dropdown-item dropdownUserBtn darkBtn btnWithBorders" href="index.php?controller=User&action=logout">Se déconnecter</a></li>
                        <?php
                        } ?>
                    </ul>
                </div>

                <!-- MODE CLAIR/SOMBRE -->
                <i id="btnModeDark" class="bi bi-moon-fill text-dark fs-3 ms-3" style="cursor: pointer;"></i>

            </div>
        </nav>

        <!--BARRE DE NAVIGATION SECONDAIRE -->
        <?php
        if (!isset($_SESSION["user"]) || $_SESSION["user"]["type"] === "user") { ?>
            <!-- ADMIN NON CONNECTE : AFFICHAGE MENU SIMPLE -->
            <nav class="navbar navbar-expand-md pt-0">
                <div class="container">
                    <div id="navbarCat" class="collapse navbar-collapse justify-content-center">
                        <ul class="navbar-nav fs-5 fw-medium">
                            <li class="nav-item"><a class="nav-link menuLinks darkTypo nav_cat" href="index.php?controller=Film&action=home">Films</a></li>
                            <li class="nav-item"><a class="nav-link menuLinks darkTypo nav_cat" href="index.php?controller=Actor&action=home">Acteurs</a></li>
                            <li class="nav-item"><a class="nav-link menuLinks darkTypo nav_cat" href="index.php?controller=Director&action=home">Réalisateurs</a></li>
                            <li class="nav-item"><a class="nav-link menuLinks darkTypo nav_cat" href="index.php?controller=Selection&action=home">Collections</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
        <?php
        }
        if (isset($_SESSION["user"]) && $_SESSION["user"]["type"] === "admin") { ?>
            <!-- ADMIN CONNECTE : AFFICHAGE MENU AVEC OPERATIONS DE CRUD DISPONIBLES -->
            <nav class="navbar navbar-expand-md pt-0">
                <div class="container">
                    <div id="navbarCat" class="collapse navbar-collapse justify-content-center">
                        <ul class="navbar-nav fs-5 fw-medium">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle menuLinks darkTypo" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Films
                                </a>
                                <ul class="dropdown-menu darkBtn btnWithBorders py-0">
                                    <li><a class="dropdown-item dropdownUserBtn darkBtn btnWithBorders" href="index.php?controller=Film&action=home">Listes Films</a></li>
                                    <li><a class="dropdown-item dropdownUserBtn darkBtn btnWithBorders" href="index.php?controller=Film&action=addForm">Ajouter Film</a></li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle menuLinks darkTypo" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Acteurs
                                </a>
                                <ul class="dropdown-menu darkBtn btnWithBorders py-0">
                                    <li><a class="dropdown-item dropdownUserBtn darkBtn btnWithBorders" href="index.php?controller=Actor&action=home">Liste Acteurs</a></li>
                                    <li><a class="dropdown-item dropdownUserBtn darkBtn btnWithBorders" href="index.php?controller=Actor&action=addForm">Ajouter acteur</a></li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle menuLinks darkTypo" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Réalisateurs
                                </a>
                                <ul class="dropdown-menu darkBtn btnWithBorders py-0">
                                    <li><a class="dropdown-item dropdownUserBtn darkBtn btnWithBorders" href="index.php?controller=Director&action=home">Liste réalisateurs</a></li>
                                    <li><a class="dropdown-item dropdownUserBtn darkBtn btnWithBorders" href="index.php?controller=Director&action=addForm">Ajouter réalisateurs</a></li>
                                </ul>
                            </li>
                            <li class="nav-item"><a class="nav-link menuLinks darkTypo" href="index.php?controller=Selection&action=home">Collections</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
        <?php
        } ?>
        <div class="darkTypo border-bottom border-1 border-opacity-10"></div>
    </header>


    <main>
        <div class="container my-5">

            <!------------------------------------->
            <!-- POSSIBLE MESSAGE D'INFORMATIONS -->
            <!------------------------------------->
            <?php
            $messageKO = isset($_GET["msgKO"]) ? $_GET["msgKO"] : "";
            $messageOK = isset($_GET["msgOK"]) ? $_GET["msgKO"] : "";
            ?>
            <div id="message" class="text-center">
                <?php if ($messageKO) { ?>
                    <p class="text-danger"><?= $messageKO ?></p>
                <?php
                }
                if ($messageOK) { ?>
                    <p class="text-success"><?= $messageOK ?></p>
                <?php
                } ?>
            </div>