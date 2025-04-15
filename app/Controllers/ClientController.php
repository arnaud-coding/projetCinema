<?php

// DEFINITION DE L'ESPACE DE NOM
namespace App\Controllers;

// IMPORT DE CLASSES
use App\Controllers\Controller as Controller;
use App\Entities\Client as Client;
use App\Entities\Mail as Mail;
use App\Models\ClientModel as ClientModel;
use App\Models\MailModel as MailModel;
use Exception;
use DateTime;

// ------------------------------------
// CLASSE CONTROLEUR DE L'ENTITE CLIENT
// ------------------------------------
class ClientController extends Controller
{
    // -----------------------------------------------------
    // METHODE POUR CONTROLER L'EXISTENCE D'UN COOKIE "RGPD"
    // -----------------------------------------------------
    public function ctrlCookie()
    {
        // RETOUR VERS LE FETCH
        echo json_encode(isset($_COOKIE["ackCookie"]));
    }

    // --------------------------------------------
    // METHODE POUR DEFINIR l'ETAT DU COOKIE "RGPD"
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
    // METHODE POUR AFFICHER UN FORMULAIRE DE CONNEXION
    // ------------------------------------------------
    public function formLogin()
    {
        // CREATTION D'UN TOKEN CSRF
        $this->generateToken();

        // ENVOI VERS LE CONTROLEUR PRINCIPAL POUR L'AFFICHAGE
        $this->render("client/formLogin");
    }

    // -------------------------
    // METHODE POUR SE CONNECTER
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
                    $readClient = new Client();
                    $readClient->setEmail($email);
                    $readClientModel = new ClientModel();
                    $client = $readClientModel->readByEmail($readClient);
                    // var_dump($client);
                    // die;

                    // VERIFICATION DE L'EXISTENCE DE L'EMAIL CLIENT ET DU MDP
                    if ($client && (password_verify($mdp, $client->mdp))) {

                        // CREATION D'UNE NOUVELLE SESSION
                        session_regenerate_id();

                        // DEFINITION DE LA SESSION CLIENT
                        $_SESSION["user"] = [
                            "id_client" => $client->id_client,
                            "prenom" => $client->prenom,
                            "nom" => $client->nom,
                            "email" => $client->email,
                            "adresse" => $client->adresse,
                            "cp" => $client->cp,
                            "ville" => $client->ville
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
                        $this->myHeader("Client", "formLogin", "error_login");
                    }
                } else {

                    // ENVOI VERS LE CONTROLEUR PRINCIPAL POUR LE RECHARGEMENT
                    $this->myHeader("Client", "formLogin", "error_input");
                }
            } else {

                // ENVOI VERS LE CONTROLEUR PRINCIPAL POUR LE RECHARGEMENT
                $this->myHeader("Client", "formLogin", "error_token");
            }
        }
    }

    // ---------------------------
    // METHODE POUR SE DECONNECTER
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
    // METHODE POUR AFFICHER UN FORMULAIRE DE REINISIALISATION
    // -------------------------------------------------------
    public function formForgetMdp()
    {
        // CREATION D'UN TOKEN CSRF
        $this->generateToken();

        // ENVOI VERS LE CONTROLEUR PRINCIPAL POUR L'AFFICHAGE
        $this->render("client/formForgetMdp");
    }
    /*
    // ------------------------------------
    // METHODE POUR REINITIALISATION UN MDP
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
                    $majClient = new Client();
                    $majClient->setEmail($_POST["email"]);
                    $majClientModel = new ClientModel();
                    $client = $majClientModel->readByEmail($majClient);

                    if ($client) {

                        // GENERATION D'UN TOKEN ET D'UNE DATE D'EXPIRATION
                        $token = bin2hex(random_bytes(32)); // 64 caractères
                        $date = date("Y-m-d H:i:s", strtotime("+1 hour"));

                        // MISE A JOUR DE L'CLIENT AVEC LE TOKEN ET LA DATE D'EXPIRATION
                        $majClient->setToken($token);
                        $majClient->setToken_expiration($date);
                        $success1 = $majClientModel->updateToken($majClient);

                        // ENVOI D'UN MAIL DE REINITIALISATION
                        $majMdpMail = new Mail();
                        $majMdpMail->setPrenom($client->prenom);
                        $majMdpMail->setNom($client->nom);
                        $majMdpMail->setEmail($client->email);
                        $majMdpMail->setToken($token);
                        $majMdpMailModel = new MailModel();
                        $success2 = $majMdpMailModel->mdpForget($majMdpMail);

                        // VERIFICATION DES ACCUSES DE TRAITEMENT
                        // ENVOI VERS LE CONTROLEUR PRINCIPAL POUR LE RECHARGEMENT
                        $success1 && $success2
                            ? $this->myHeader("Home", "home", "success_email")
                            : $this->myHeader("Client", "formForgetMdp", "error_email");
                    } else {

                        // ENVOI VERS LE CONTROLEUR PRINCIPAL POUR LE RECHARGEMENT
                        $this->myHeader("Client", "formCreate", "error_noEmail");
                    }
                } else {

                    // ENVOI VERS LE CONTROLEUR PRINCIPAL POUR LE RECHARGEMENT
                    $this->myHeader("Client", "formForgetMdp", "error_inputEmail");
                }
            } else {

                // ENVOI VERS LE CONTROLEUR PRINCIPAL POUR LE RECHARGEMENT
                $this->myHeader("Client", "formForgetMdp", "error_token");
            }
        }
    }

    // -------------------------------------------------------
    // METHODE POUR AFFICHER UN FORMULAIRE DE REINITIALISATION
    // -------------------------------------------------------
    public function formUpdateMdp()
    {
        // VERIFICATION DU GET
        if ($_GET["token"] ?? null) {

            // CREATION D'UN TOKEN CSRF
            $this->generateToken();

            // LECTURE DE L'CLIENT AVEC LE TOKEN
            $readClient = new Client();
            $readClient->setToken($_GET["token"]);
            $readClientModel = new ClientModel();
            $client = $readClientModel->readByToken($readClient);
            if ($client && ($_GET["token"] === $client->token)) {

                // VERIFICATION DE LA DATE D'EXPIRATION
                // ENVOI VERS LE CONTROLEUR PRINCIPAL POUR L'AFFICHAGE OU LE RECHARGEMENT
                strtotime($client->token_expire) > time()
                    ? $this->render("client/formUpdateMdp")
                    : $this->myHeader("Client", "formForgetMdp", "error_expire");
            } else {

                // ENVOI VERS LE CONTROLEUR PRINCIPAL POUR LE RECHARGEMENT
                $this->myHeader("Client", "formForgetMdp", "error_link");
            }
        } else {

            // ENVOI VERS LE CONTROLEUR PRINCIPAL POUR LE RECHARGEMENT
            $this->myHeader("Home", "home", "error_id");
        }
    }

    // ----------------------------
    // METHODE POUR MODIFIER LE MDP
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
                    $majClient = new Client();
                    $majClient->setToken($token);
                    $majClientModel = new ClientModel();
                    $client = $majClientModel->readByToken($majClient);

                    // MISE A JOUR DU MDP
                    $majClient->setEmail($client->email);
                    $majClient->setMdp($mdp);
                    $majClient->setToken(null); // Réinitialisation du token
                    $majClient->setToken_expire(null); // Réinitialisation de la date d'expiration
                    $success = $majClientModel->updateMdp($majClient);

                    // VERIFICATION DE L'ACCUSE DE TRAITEMENT
                    // ENVOI VERS LE CONTROLEUR PRINCIPAL POUR LE RECHARGEMENT
                    $success
                        ? $this->myHeader("Client", "formLogin", "success_updateMdp")
                        : $this->myHeader("Client", "formUpdateMdp", "error_request");
                } else {

                    // ENVOI VERS LE CONTROLEUR PRINCIPAL POUR LE RECHARGEMENT
                    $this->myHeader("Client", "formUpdateMdp", "error_input");
                }
            } else {

                // ENVOI VERS LE CONTROLEUR PRINCIPAL POUR LE RECHARGEMENT
                $this->myHeader("Client", "formUpdateMdp", "error_token");
            }
        }
    }
*/
    // -----------------------------------------------
    // METHODE POUR AFFICHER UN FORMULAIRE DE CREATION
    // -----------------------------------------------
    public function formCreate()
    {
        // CREATION D'UN TOKEN CSRF
        $this->generateToken();

        // ENVOI VERS LE CONTROLEUR PRINCIPAL POUR L'AFFICHAGE
        $this->render("client/formCreate");
    }

    // ----------------------------
    // METHODE POUR CREER UN CLIENT
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
                $prenom = $_POST["prenom"] ?? null;
                $nom = $_POST["nom"] ?? null;
                $email = $_POST["email"] ?? null;
                $mdp = $_POST["password"] ?? null;
                $adresse = $_POST["adresse"] ?? null;
                $cp = $_POST["cp"] ?? null;
                $ville = $_POST["ville"] ?? null;

                if ($prenom && $nom && $email && $mdp && $adresse && $cp && $ville) {

                    // CREATION D'UN CLIENT
                    $addClient = new Client();
                    $addClient->setPrenom($prenom);
                    $addClient->setNom($nom);
                    $addClient->setEmail($email);
                    $addClient->setMdp($mdp);
                    $addClient->setAdresse($adresse);
                    $addClient->setCp($cp);
                    $addClient->setVille($ville);
                    $addClientModel = new ClientModel();
                    $success = $addClientModel->create($addClient);

                    if ($success === true) { // VERIFICATION DE L'ACCUSE DE TRAITEMENT

                        // REDIRECTION VERS LA PAGE LOGIN
                        $this->myHeader("Client", "formLogin", "success_createUserByUser");
                    } elseif ($success === "emailExistant") { // VERIFICATION DE L'EXISTENCE DE L'EMAIL

                        // EMAIL DEJA EXISTANT DANS LA BDD : RENVOI VERS LE CONTROLEUR PRINCIPAL POUR LE RECHARGEMENT
                        $this->myHeader("Client", "formLogin", "error_userFound");
                    } else {

                        // ENVOI VERS LE CONTROLEUR PRINCIPAL POUR LE RECHARGEMENT
                        $this->myHeader("Client", "formCreate", "error_request");
                    }
                } else {

                    // ENVOI VERS LE CONTROLEUR PRINCIPAL POUR LE RECHARGEMENT
                    $this->myHeader("Client", "formCreate", "error_input");
                }
            } else {

                // ENVOI VERS LE CONTROLEUR PRINCIPAL POUR LE RECHARGEMENT
                $this->myHeader("Client", "formCreate", "error_token");
            }
        }
    }

    // --------------------------------
    //  METHODE POUR AFFICHER LE PANIER
    // --------------------------------
    public function displayCart()
    {
        $this->render('client/panier');
    }

    // -----------------------------------------
    // METHODE POUR AJOUTER UN PRODUIT AU PANIER
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
        header('Location: index.php?controller=Client&action=displayCart');
    }

    // -------------------------------------------------------------
    // METHODE POUR MODIFIER LA QUANTITE D'UN PRODUIT DANS LE PANIER
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

        header('Location: index.php?controller=Client&action=displayCart');
    }

    // ----------------------------
    // METHODE POUR VIDER LE PANIER
    // ----------------------------
    public function clearCart()
    {
        unset($_SESSION['panier']);
        unset($_SESSION['montant_commande']);
        header('Location: index.php?controller=Client&action=displayCart');
    }

    // ----------------------------
    // METHODE POUR RETIRER UN ARTICLE DU PANIER
    // ----------------------------
    public function removeFromCart()
    {
        $panier = isset($_SESSION['panier']) ? $_SESSION['panier'] : [];
        $produit = intval($_GET['produit']) ?? null;

        array_splice($panier, $produit, 1);
        $_SESSION['panier'] = $panier; // mise à jour de la session panier

        header('Location: index.php?controller=Client&action=displayCart');
    }

    // ---------------------------------
    // METHODE POUR VALIDER LA COMMANDE
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
                'id_client' => $_SESSION['user']['id_client'],
                'prenom' => $_SESSION['user']['prenom'],
                'nom' => $_SESSION['user']['nom'],
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

                // Succès de la requête HTTP : Envoi du mail de confirmation au client
                $mail = new Mail();
                $mail->setPrenom($_SESSION['user']['prenom']);
                $mail->setNom($_SESSION['user']['nom']);
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
    // METHODE POUR AFFICHER UN FORMULAIRE DE MISE A JOUR
    // --------------------------------------------------
    public function formUpdate()
    {
        // VERIFICATION DES DROITS D'ACCES
        if (isset($_SESSION["user"]["id_client"])) {

            // VERIFICATION DU GET
            if ($_GET["id_client"] ?? null) {

                // CREATION D'UN TOKEN CSRF
                $this->generateToken();

                // LECTURE DE L'CLIENT
                $readClient = new Client();
                $readClient->setId_client($_GET["id_client"]);
                $readClientModel = new ClientModel();
                $client = $readClientModel->readById($readClient);

                // VERIFICATION DE L'EXISTENCE DE L'CLIENT
                if ($client) {

                    // ENVOI VERS LE CONTROLEUR PRINCIPAL POUR L'AFFICHAGE
                    $this->render("client/formUpdate", ["client" => $client]);
                } else {

                    // ENVOI VERS LE CONTROLEUR PRINCIPAL POUR LE RECHARGEMENT
                    $_SESSION["user"]["statut"] === "admin"
                        ? $this->myHeader("Client", "listAdmin", "error_request")
                        : $this->myHeader("Home", "home", "error_request");
                }
            } else {

                // ENVOI VERS LE CONTROLEUR PRINCIPAL POUR LE RECHARGEMENT
                $_SESSION["user"]["statut"] === "admin"
                    ? $this->myHeader("Client", "listAdmin", "error_id")
                    : $this->myHeader("Home", "home", "error_id");
            }
        } else {

            // ENVOI VERS LE CONTROLEUR PRINCIPAL POUR LE RECHARGEMENT
            $this->myHeader("Home", "home", "error_rights");
        }
    }

    // -------------------------------
    // METHODE POUR MODIFIER UN CLIENT
    // -------------------------------
    public function update()
    {
        // VERIFICATION DES DROITS D'ACCES
        if (isset($_SESSION["user"]["id_client"])) {

            // VERIFICATION DE LA METHODE POST
            if ($_SERVER["REQUEST_METHOD"] === "POST") {

                // VERIFICATION DU TOKEN
                $token = $_POST["token"] ?? "";
                if ((hash_equals($_SESSION["token"]["id"], $token)) && (time() < $_SESSION["token"]["token_expiration"])) {

                    // SUPPRESSION DU TOKEN
                    unset($_SESSION["token"]);

                    // VERIFICATION DES CHAMPS
                    $id_client = $_POST["id_client"] ?? null;
                    $prenom = $_POST["prenom"] ?? null;
                    $nom = $_POST["nom"] ?? null;
                    $email = $_POST["email"] ?? null;
                    $mdp = $_POST["mdp"] ?? ""; // Le mot de passe peut être nul.
                    $statut = $_POST["statut"] ?? "user"; // Statut user minimum
                    if ($id_client && $prenom && $nom && $email) {

                        // MISE A JOUR DE L'CLIENT
                        $majClient = new Client();
                        $majClient->setId_client($id_client);
                        $majClient->setPrenom($prenom);
                        $majClient->setNom($nom);
                        $majClient->setEmail($email);
                        $majClient->setMdp($mdp);
                        $majClient->setStatut($statut);

                        $majClientModel = new ClientModel();
                        $success = $majClientModel->update($majClient);

                        // VERIFICATION DE L'ACCUSE DE TRAITEMENT
                        // ENVOI VERS LE CONTROLEUR PRINCIPAL POUR LE RECHARGEMENT
                        if ($success) {
                            $_SESSION["user"]["statut"] === "admin"
                                ? $this->myHeader("Client", "listAdmin", "success_updateUserByAdmin")
                                : $this->myHeader("Home", "home", "success_userUpdateUserByUser");
                        } else {
                            $this->myHeader("Client", "formUpdate", "error_request", ["id_client" => $id_client]);
                        }
                    } else {

                        // ENVOI VERS LE CONTROLEUR PRINCIPAL POUR LE RECHARGEMENT
                        $this->myHeader("Client", "formUpdate", "error_input", ["id_client" => $id_client]);
                    }
                } else {

                    // ENVOI VERS LE CONTROLEUR PRINCIPAL POUR LE RECHARGEMENT
                    $this->myHeader("Client", "formUpdate", "error_token");
                }
            }
        } else {

            // ENVOI VERS LE CONTROLEUR PRINCIPAL POUR LE RECHARGEMENT
            $this->myHeader("Home", "home", "error_rights");
        }
    }
        */
}
