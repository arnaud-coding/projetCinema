<?php

// DEFINITION DE L'ESPACE DE NOM
namespace App\Controllers;

// IMPORT DE CLASSES
use App\Controllers\Controller as Controller;
use App\Entities\User as User;
use App\Entities\Mail as Mail;
use App\Models\UserModel as UserModel;
use App\Models\MailModel as MailModel;
use Exception;
use DateTime;

// ------------------------------------
// CLASSE CONTROLEUR DE L'ENTITE CLIENT
// ------------------------------------
class UserController extends Controller
{
    // -----------------------------------------------------
    //  CONTROLER L'EXISTENCE D'UN COOKIE "RGPD"
    // -----------------------------------------------------
    public function ctrlCookie()
    {
        // RETOUR VERS LE FETCH
        echo json_encode(isset($_COOKIE["ackCookie"]));
    }

    // --------------------------------------------
    //  DEFINIR l'ETAT DU COOKIE "RGPD"
    // --------------------------------------------
    public function validCookie()
    {
        // VERIFICATION DU GET
        $valid = $_GET["cookie"] ?? "";
        if ($valid === "accept") {
            setcookie("ackCookie", "yes", time() + 365 * 24 * 3600, "/"); // Expire dans 1 an
        } else {
            setcookie("ackCookie", "no", time() + 365 * 24 * 3600, "/"); // Expire dans 1 an sans acceptation
        }

        // RETOUR VERS LE FETCH
        echo json_encode(true);
    }

    // ------------------------------------------------
    //  AFFICHER UN FORMULAIRE DE CONNEXION
    // ------------------------------------------------
    public function formLogin()
    {
        // CREATTION D'UN TOKEN CSRF
        $this->generateToken();

        // ENVOI VERS LE CONTROLEUR PRINCIPAL POUR L'AFFICHAGE
        $this->render("user/formLogin");
    }

    // -------------------------
    //  SE CONNECTER
    // -------------------------
    public function login()
    {
        // VERIFICATION DE LA METHODE POST
        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            // VERIFICATION DU TOKEN
            $token = $_POST["token"] ?? "";
            if ((hash_equals($_SESSION["token"]["id"], $token)) && (time() < $_SESSION["token"]["token_expiration"])) {

                // SUPPRESSION DU TOKEN
                unset($_SESSION["token"]);

                // VERIFICATION DES CHAMPS
                $email = $_POST["email"] ?? null;
                $mdp = $_POST["mdp"] ?? null;
                // var_dump($_POST);
                // die;
                if ($email && $mdp) {

                    // LECTURE DE L'EMAIL CLIENT
                    $readUser = new User();
                    $readUser->setEmail($email);
                    $readUserModel = new UserModel();
                    $user = $readUserModel->readByEmail($readUser);
                    // var_dump($user);
                    // die;

                    // VERIFICATION DE L'EXISTENCE DE L'EMAIL CLIENT ET DU MDP
                    if ($user && (password_verify($mdp, $user->mdp))) {

                        // CREATION D'UNE NOUVELLE SESSION
                        session_regenerate_id();

                        // DEFINITION DE LA SESSION CLIENT
                        $_SESSION["user"] = [
                            "id_user" => $user->id_user,
                            "firstname" => $user->firstname,
                            "lastname" => $user->lastname,
                            "email" => $user->email,
                            "adresse" => $user->adresse,
                            "cp" => $user->cp,
                            "ville" => $user->ville
                        ];

                        // DEFINITION DES COOKIES CLIENT
                        // if ($_COOKIE["ackCookie"] === "yes") {
                        //     foreach ($_SESSION["user"] as $name => $value) {
                        //         setcookie($name, $value, time() + 86400, "/");
                        //     }
                        // }

                        // ENVOI VERS LE CONTROLEUR PRINCIPAL POUR LE RECHARGEMENT
                        $this->myHeader("Home", "home", "success_login");
                    } else {

                        // ENVOI VERS LE CONTROLEUR PRINCIPAL POUR LE RECHARGEMENT
                        $this->myHeader("User", "formLogin", "error_login");
                    }
                } else {

                    // ENVOI VERS LE CONTROLEUR PRINCIPAL POUR LE RECHARGEMENT
                    $this->myHeader("User", "formLogin", "error_input");
                }
            } else {

                // ENVOI VERS LE CONTROLEUR PRINCIPAL POUR LE RECHARGEMENT
                $this->myHeader("User", "formLogin", "error_token");
            }
        }
    }

    // ---------------------------
    //  SE DECONNECTER
    // ---------------------------
    public function logout()
    {
        // DESTRUCTION DES COOKIES CLIENT
        foreach ($_SESSION["user"] as $name => $value) {
            setcookie($name, "", time() - 3600, "/");
        }

        // DESTRUCTION DE LA SESSION CLIENT
        unset($_SESSION["user"]);
        session_destroy();

        // ENVOI VERS LE CONTROLEUR PRINCIPAL POUR LE RECHARGEMENT
        $this->myHeader("Home", "home", "success_logout");
    }

    // -------------------------------------------------------
    //  AFFICHER UN FORMULAIRE DE REINISIALISATION
    // -------------------------------------------------------
    public function formForgetMdp()
    {
        // CREATION D'UN TOKEN CSRF
        $this->generateToken();

        // ENVOI VERS LE CONTROLEUR PRINCIPAL POUR L'AFFICHAGE
        $this->render("user/formForgetMdp");
    }
    /*
    // ------------------------------------
    //  REINITIALISATION UN MDP
    // ------------------------------------
    public function forgetMdp()
    {
        // VERIFICATION DE LA METHODE POST
        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            // VERIFICATION DU TOKEN
            $token = $_POST["token"] ?? "";
            if ((hash_equals($_SESSION["token"]["id"], $token)) && (time() < $_SESSION["token"]["token_expiration"])) {

                // SUPPRESSION DU TOKEN
                unset($_SESSION["token"]);

                // VERIFICATION DU CHAMP EMAIL
                if ($_POST["email"] ?? null) {

                    // LECTURE DE L'CLIENT
                    $majUser = new User();
                    $majUser->setEmail($_POST["email"]);
                    $majUserModel = new UserModel();
                    $user = $majUserModel->readByEmail($majUser);

                    if ($user) {

                        // GENERATION D'UN TOKEN ET D'UNE DATE D'EXPIRATION
                        $token = bin2hex(random_bytes(32)); // 64 caractères
                        $date = date("Y-m-d H:i:s", strtotime("+1 hour"));

                        // MISE A JOUR DE L'CLIENT AVEC LE TOKEN ET LA DATE D'EXPIRATION
                        $majUser->setToken($token);
                        $majUser->setToken_expiration($date);
                        $success1 = $majUserModel->updateToken($majUser);

                        // ENVOI D'UN MAIL DE REINITIALISATION
                        $majMdpMail = new Mail();
                        $majMdpMail->setFirstname($user->firstname);
                        $majMdpMail->setLastname($user->lastname);
                        $majMdpMail->setEmail($user->email);
                        $majMdpMail->setToken($token);
                        $majMdpMailModel = new MailModel();
                        $success2 = $majMdpMailModel->mdpForget($majMdpMail);

                        // VERIFICATION DES ACCUSES DE TRAITEMENT
                        // ENVOI VERS LE CONTROLEUR PRINCIPAL POUR LE RECHARGEMENT
                        $success1 && $success2
                            ? $this->myHeader("Home", "home", "success_email")
                            : $this->myHeader("User", "formForgetMdp", "error_email");
                    } else {

                        // ENVOI VERS LE CONTROLEUR PRINCIPAL POUR LE RECHARGEMENT
                        $this->myHeader("User", "formCreate", "error_noEmail");
                    }
                } else {

                    // ENVOI VERS LE CONTROLEUR PRINCIPAL POUR LE RECHARGEMENT
                    $this->myHeader("User", "formForgetMdp", "error_inputEmail");
                }
            } else {

                // ENVOI VERS LE CONTROLEUR PRINCIPAL POUR LE RECHARGEMENT
                $this->myHeader("User", "formForgetMdp", "error_token");
            }
        }
    }

    // -------------------------------------------------------
    //  AFFICHER UN FORMULAIRE DE REINITIALISATION
    // -------------------------------------------------------
    public function formUpdateMdp()
    {
        // VERIFICATION DU GET
        if ($_GET["token"] ?? null) {

            // CREATION D'UN TOKEN CSRF
            $this->generateToken();

            // LECTURE DE L'CLIENT AVEC LE TOKEN
            $readUser = new User();
            $readUser->setToken($_GET["token"]);
            $readUserModel = new UserModel();
            $user = $readUserModel->readByToken($readUser);
            if ($user && ($_GET["token"] === $user->token)) {

                // VERIFICATION DE LA DATE D'EXPIRATION
                // ENVOI VERS LE CONTROLEUR PRINCIPAL POUR L'AFFICHAGE OU LE RECHARGEMENT
                strtotime($user->token_expire) > time()
                    ? $this->render("user/formUpdateMdp")
                    : $this->myHeader("User", "formForgetMdp", "error_expire");
            } else {

                // ENVOI VERS LE CONTROLEUR PRINCIPAL POUR LE RECHARGEMENT
                $this->myHeader("User", "formForgetMdp", "error_link");
            }
        } else {

            // ENVOI VERS LE CONTROLEUR PRINCIPAL POUR LE RECHARGEMENT
            $this->myHeader("Home", "home", "error_id");
        }
    }

    // ----------------------------
    //  MODIFIER LE MDP
    // ----------------------------
    public function updateMdp()
    {
        // VERIFICATION DE LA METHODE POST
        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            // VERIFICATION DU TOKEN
            $token = $_POST["token"] ?? "";
            if ((hash_equals($_SESSION["token"]["id"], $token)) && (time() < $_SESSION["token"]["token_expiration"])) {

                // SUPPRESSION DU TOKEN
                unset($_SESSION["token"]);

                // VERIFICATION DES CHAMPS
                $token = $_POST["token"] ?? null;
                $mdp = $_POST["mdp"] ?? null;
                if ($token && $mdp) {

                    // LECTURE DE L'CLIENT AVEC LE TOKEN
                    $majUser = new User();
                    $majUser->setToken($token);
                    $majUserModel = new UserModel();
                    $user = $majUserModel->readByToken($majUser);

                    // MISE A JOUR DU MDP
                    $majUser->setEmail($user->email);
                    $majUser->setMdp($mdp);
                    $majUser->setToken(null); // Réinitialisation du token
                    $majUser->setToken_expire(null); // Réinitialisation de la date d'expiration
                    $success = $majUserModel->updateMdp($majUser);

                    // VERIFICATION DE L'ACCUSE DE TRAITEMENT
                    // ENVOI VERS LE CONTROLEUR PRINCIPAL POUR LE RECHARGEMENT
                    $success
                        ? $this->myHeader("User", "formLogin", "success_updateMdp")
                        : $this->myHeader("User", "formUpdateMdp", "error_request");
                } else {

                    // ENVOI VERS LE CONTROLEUR PRINCIPAL POUR LE RECHARGEMENT
                    $this->myHeader("User", "formUpdateMdp", "error_input");
                }
            } else {

                // ENVOI VERS LE CONTROLEUR PRINCIPAL POUR LE RECHARGEMENT
                $this->myHeader("User", "formUpdateMdp", "error_token");
            }
        }
    }
*/
    // -----------------------------------------------
    //  AFFICHER UN FORMULAIRE DE CREATION
    // -----------------------------------------------
    public function formCreate()
    {
        // CREATION D'UN TOKEN CSRF
        $this->generateToken();

        // ENVOI VERS LE CONTROLEUR PRINCIPAL POUR L'AFFICHAGE
        $this->render("user/formCreate");
    }

    // ----------------------------
    //  CREER UN CLIENT
    // ----------------------------
    public function create()
    {
        // VERIFICATION DE LA METHODE POST
        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            // VERIFICATION DU TOKEN
            $token = $_POST["token"] ?? "";
            if ((hash_equals($_SESSION["token"]["id"], $token)) && (time() < $_SESSION["token"]["token_expiration"])) {

                // SUPPRESSION DU TOKEN
                unset($_SESSION["token"]);

                // VERIFICATION DES CHAMPS
                $firstname = $_POST["firstname"] ?? null;
                $lastname = $_POST["lastname"] ?? null;
                $email = $_POST["email"] ?? null;
                $mdp = $_POST["password"] ?? null;
                $adresse = $_POST["adresse"] ?? null;
                $cp = $_POST["cp"] ?? null;
                $ville = $_POST["ville"] ?? null;

                if ($firstname && $lastname && $email && $mdp && $adresse && $cp && $ville) {

                    // CREATION D'UN CLIENT
                    $addUser = new User();
                    $addUser->setFirstname($firstname);
                    $addUser->setLastname($lastname);
                    $addUser->setEmail($email);
                    $addUser->setMdp($mdp);
                    $addUser->setAdresse($adresse);
                    $addUser->setCp($cp);
                    $addUser->setVille($ville);
                    $addUserModel = new UserModel();
                    $success = $addUserModel->create($addUser);

                    if ($success === true) { // VERIFICATION DE L'ACCUSE DE TRAITEMENT

                        // REDIRECTION VERS LA PAGE LOGIN
                        $this->myHeader("User", "formLogin", "success_createUserByUser");
                    } elseif ($success === "emailExistant") { // VERIFICATION DE L'EXISTENCE DE L'EMAIL

                        // EMAIL DEJA EXISTANT DANS LA BDD : RENVOI VERS LE CONTROLEUR PRINCIPAL POUR LE RECHARGEMENT
                        $this->myHeader("User", "formLogin", "error_userFound");
                    } else {

                        // ENVOI VERS LE CONTROLEUR PRINCIPAL POUR LE RECHARGEMENT
                        $this->myHeader("User", "formCreate", "error_request");
                    }
                } else {

                    // ENVOI VERS LE CONTROLEUR PRINCIPAL POUR LE RECHARGEMENT
                    $this->myHeader("User", "formCreate", "error_input");
                }
            } else {

                // ENVOI VERS LE CONTROLEUR PRINCIPAL POUR LE RECHARGEMENT
                $this->myHeader("User", "formCreate", "error_token");
            }
        }
    }

    // --------------------------------
    //   AFFICHER LE PANIER
    // --------------------------------
    public function displayCart()
    {
        $this->render('user/panier');
    }

    // -----------------------------------------
    //  AJOUTER UN PRODUIT AU PANIER
    // -----------------------------------------
    public function addToCart()
    {
        $id_produit = intval($_GET['id_produit']) ?? null;
        $prix = floatval($_GET['prix']) ?? null;
        $panier = isset($_SESSION['panier']) ? $_SESSION['panier'] : [];
        $produit = [
            'id_produit' => $id_produit,
            'quantite' => 1,
            'prix' => $prix
        ];

        if ($produit) {
            $panier[] = $produit; // Même effet que : array_push($panier, $produit)
            $_SESSION['panier'] = $panier; // mise à jour de la session panier
        }
        header('Location: index.php?controller=User&action=displayCart');
    }

    // -------------------------------------------------------------
    //  MODIFIER LA QUANTITE D'UN PRODUIT DANS LE PANIER
    // -------------------------------------------------------------
    public function setQuantity()
    {
        $index = $_POST['indexPanier'] ?? null;
        $id_produit = intval($_POST['id_produit']) ?? null;
        $quantite = intval($_POST['quantite']) ?? null;
        $prix = floatval($_POST['prix']) ?? null;
        $_SESSION['panier'][$index] = [
            'id_produit' => $id_produit,
            'quantite' => $quantite,
            'prix' => $prix * $quantite
        ];

        header('Location: index.php?controller=User&action=displayCart');
    }

    // ----------------------------
    //  VIDER LE PANIER
    // ----------------------------
    public function clearCart()
    {
        unset($_SESSION['panier']);
        unset($_SESSION['montant_commande']);
        header('Location: index.php?controller=User&action=displayCart');
    }

    // ----------------------------
    //  RETIRER UN ARTICLE DU PANIER
    // ----------------------------
    public function removeFromCart()
    {
        $panier = isset($_SESSION['panier']) ? $_SESSION['panier'] : [];
        $produit = intval($_GET['produit']) ?? null;

        array_splice($panier, $produit, 1);
        $_SESSION['panier'] = $panier; // mise à jour de la session panier

        header('Location: index.php?controller=User&action=displayCart');
    }

    // ---------------------------------
    //  VALIDER LA COMMANDE
    // ---------------------------------
    public function validateOrder()
    {

        try {
            // Envoi la requete de création de la commande

            // =================================================================================
            $url = 'https://www.cefii-developpements.fr/olivier1422/cefii_market/market_api/public/index.php?controller=Commande&action=add';

            // Données
            $num_commande = (new DateTime())->getTimestamp();
            $date_commande = (new DateTime())->format('Y-m-d');
            $data = [
                'id_user' => $_SESSION['user']['id_user'],
                'firstname' => $_SESSION['user']['firstname'],
                'lastname' => $_SESSION['user']['lastname'],
                'num_commande' => $num_commande,
                'date_commande' => $date_commande,
                'email' => $_SESSION['user']['email'],
                'adresse' => $_SESSION['user']['adresse'],
                'cp' => $_SESSION['user']['cp'],
                'ville' => $_SESSION['user']['ville'],
                'produits' => $_SESSION['panier']
            ];


            // Conversion des données en JSON
            $jsonData = json_encode($data);

            // Créer le contexte de flux
            $opts = [
                'http' =>
                [
                    'method' => 'POST',
                    'header' => 'Content-type: application/json',
                    'content' => $jsonData
                ]
            ];

            $context = stream_context_create($opts);

            // Envoyer la requête POST
            file_get_contents($url, false, $context);


            // Obtient le statut de la reponse
            $http_response_code = intval(explode(" ", $http_response_header[0])[1]);

            // vérifie la réponse à la requete
            if ($http_response_code !== 201) {
                // La requete HTTP a échouée: retourne à la page d'acceuil avec un message d'erreur'
                throw new Exception("Error sending command data to the API. Error code=" . $http_response_code);
            } else {

                // Succès de la requête HTTP : Envoi du mail de confirmation au user
                $mail = new Mail();
                $mail->setFirstname($_SESSION['user']['firstname']);
                $mail->setLastname($_SESSION['user']['lastname']);
                $mail->setEmail($_SESSION['user']['email']);
                $mail->setNum_commande($num_commande);
                $mail->setDate_commande($date_commande);
                $mail->setMontant_commande($_SESSION['montant_commande']);
                $mail->setAdresse($_SESSION['user']['adresse']);
                $mail->setCode_postal($_SESSION['user']['cp']);
                $mail->setVille($_SESSION['user']['ville']);
                $mailModel = new MailModel();
                $mailModel->validatedOrder($mail);

                // Commande réussie et mail de confirmation envoyé : on vide le panier
                unset($_SESSION['panier']);
                unset($_SESSION['montant_commande']);


                // La requete HTTP à réussie: redirection vers la page d'acceuil avec un message de succès
                $this->myHeader("Home", "home", "success_validateOrder");
            }
        } catch (Exception $e) {
            echo "validateOrder: Caught exception: " . $e->getMessage();
            $this->myHeader("Home", "home", "error_validateOrder");
        }
    }
    /*

    // --------------------------------------------------
    //  AFFICHER UN FORMULAIRE DE MISE A JOUR
    // --------------------------------------------------
    public function formUpdate()
    {
        // VERIFICATION DES DROITS D'ACCES
        if (isset($_SESSION["user"]["id_user"])) {

            // VERIFICATION DU GET
            if ($_GET["id_user"] ?? null) {

                // CREATION D'UN TOKEN CSRF
                $this->generateToken();

                // LECTURE DE L'CLIENT
                $readUser = new User();
                $readUser->setId_user($_GET["id_user"]);
                $readUserModel = new UserModel();
                $user = $readUserModel->readById($readUser);

                // VERIFICATION DE L'EXISTENCE DE L'CLIENT
                if ($user) {

                    // ENVOI VERS LE CONTROLEUR PRINCIPAL POUR L'AFFICHAGE
                    $this->render("user/formUpdate", ["user" => $user]);
                } else {

                    // ENVOI VERS LE CONTROLEUR PRINCIPAL POUR LE RECHARGEMENT
                    $_SESSION["user"]["statut"] === "admin"
                        ? $this->myHeader("User", "listAdmin", "error_request")
                        : $this->myHeader("Home", "home", "error_request");
                }
            } else {

                // ENVOI VERS LE CONTROLEUR PRINCIPAL POUR LE RECHARGEMENT
                $_SESSION["user"]["statut"] === "admin"
                    ? $this->myHeader("User", "listAdmin", "error_id")
                    : $this->myHeader("Home", "home", "error_id");
            }
        } else {

            // ENVOI VERS LE CONTROLEUR PRINCIPAL POUR LE RECHARGEMENT
            $this->myHeader("Home", "home", "error_rights");
        }
    }

    // -------------------------------
    //  MODIFIER UN CLIENT
    // -------------------------------
    public function update()
    {
        // VERIFICATION DES DROITS D'ACCES
        if (isset($_SESSION["user"]["id_user"])) {

            // VERIFICATION DE LA METHODE POST
            if ($_SERVER["REQUEST_METHOD"] === "POST") {

                // VERIFICATION DU TOKEN
                $token = $_POST["token"] ?? "";
                if ((hash_equals($_SESSION["token"]["id"], $token)) && (time() < $_SESSION["token"]["token_expiration"])) {

                    // SUPPRESSION DU TOKEN
                    unset($_SESSION["token"]);

                    // VERIFICATION DES CHAMPS
                    $id_user = $_POST["id_user"] ?? null;
                    $firstname = $_POST["firstname"] ?? null;
                    $lastname = $_POST["lastname"] ?? null;
                    $email = $_POST["email"] ?? null;
                    $mdp = $_POST["mdp"] ?? ""; // Le mot de passe peut être nul.
                    $statut = $_POST["statut"] ?? "user"; // Statut user minimum
                    if ($id_user && $firstname && $lastname && $email) {

                        // MISE A JOUR DE L'CLIENT
                        $majUser = new User();
                        $majUser->setId_user($id_user);
                        $majUser->setFirstname($firstname);
                        $majUser->setLastname($lastname);
                        $majUser->setEmail($email);
                        $majUser->setMdp($mdp);
                        $majUser->setStatut($statut);

                        $majUserModel = new UserModel();
                        $success = $majUserModel->update($majUser);

                        // VERIFICATION DE L'ACCUSE DE TRAITEMENT
                        // ENVOI VERS LE CONTROLEUR PRINCIPAL POUR LE RECHARGEMENT
                        if ($success) {
                            $_SESSION["user"]["statut"] === "admin"
                                ? $this->myHeader("User", "listAdmin", "success_updateUserByAdmin")
                                : $this->myHeader("Home", "home", "success_userUpdateUserByUser");
                        } else {
                            $this->myHeader("User", "formUpdate", "error_request", ["id_user" => $id_user]);
                        }
                    } else {

                        // ENVOI VERS LE CONTROLEUR PRINCIPAL POUR LE RECHARGEMENT
                        $this->myHeader("User", "formUpdate", "error_input", ["id_user" => $id_user]);
                    }
                } else {

                    // ENVOI VERS LE CONTROLEUR PRINCIPAL POUR LE RECHARGEMENT
                    $this->myHeader("User", "formUpdate", "error_token");
                }
            }
        } else {

            // ENVOI VERS LE CONTROLEUR PRINCIPAL POUR LE RECHARGEMENT
            $this->myHeader("Home", "home", "error_rights");
        }
    }
        */
}
