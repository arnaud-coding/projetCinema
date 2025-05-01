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

            //todo TOKEN
            // // VERIFICATION DU TOKEN
            // $token = $_POST["token"] ?? "";
            // if ((hash_equals($_SESSION["token"]["id"], $token)) && (time() < $_SESSION["token"]["token_expiration"])) {

            //     // SUPPRESSION DU TOKEN
            //     unset($_SESSION["token"]);
            if (true) {
                // VERIFICATION DES CHAMPS
                $email = $_POST["email"] ?? null;
                $password = $_POST["password"] ?? null;

                if ($email && $password) {

                    // LECTURE DE L'EMAIL CLIENT
                    $user = new User();
                    $user->setEmail($email);
                    $userModel = new UserModel();
                    $user = $userModel->readByEmail($user);

                    // VERIFICATION DE L'EXISTENCE DE L'EMAIL CLIENT ET DU MDP
                    if ($user && password_verify($password, $user->password)) {

                        // CREATION D'UN NOUVEAU ID DE SESSION
                        session_regenerate_id();

                        // DEFINITION DE LA SESSION CLIENT
                        $_SESSION["user"] = [
                            "id_user" => $user->id_user,
                            "pseudo" => $user->pseudo,
                            "email" => $user->email,
                            "type" => $user->type
                        ];

                        // DEFINITION DES COOKIES CLIENT
                        // inutilisé : exemple de stockage d'infos utilisateur dans les cookies
                        if ($_COOKIE["ackCookie"] === "yes") {
                            foreach ($_SESSION["user"] as $key => $value) {
                                setcookie($key, $value, time() + 86400, "/");
                            }
                        }

                        // ENVOI VERS LE CONTROLEUR PRINCIPAL POUR LE RECHARGEMENT
                        header("Location: index.php?controller=Home&action=home");
                    } else {
                        header("Location: index.php?controller=User&action=formLogin&success=" . false . "&message=" . urlencode("Mot de passe ou identifiant incorrect."));
                    }
                } else {
                    header("Location: index.php?controller=User&action=formLogin&success=" . false . "&message=" . urlencode("Le pseudo et l'email doivent être renseignés."));
                }
            } else {
                header("Location: index.php?controller=User&action=formLogin&success=" . false . "&message=" . urlencode("Erreur inattendue."));
            }
        } else {
            header("Location: index.php?controller=User&action=formLogin&success=" . false . "&message=" . urlencode("Erreur interne."));
        }
    }
    // ---------------------------
    //  SE DECONNECTER
    // ---------------------------
    public function logout()
    {
        // DESTRUCTION DES COOKIES CLIENT
        // inutilisé : exemple de suppression d'infos utilisateur des cookies
        foreach ($_SESSION["user"] as $key => $value) { // "=> $value" requis sinon "key" contient la valeur
            setcookie($key, "", time() - 3600, "/");
        }

        // DESTRUCTION DE LA SESSION CLIENT
        unset($_SESSION["user"]);
        session_destroy();

        // ENVOI VERS LE CONTROLEUR PRINCIPAL POUR LE RECHARGEMENT
        header("Location: index.php?controller=Home&action=home");
    }
    /*

    // -------------------------------------------------------
    //  AFFICHER UN FORMULAIRE DE REINISIALISATION
    // -------------------------------------------------------
    public function formForgetPassword()
    {
        // CREATION D'UN TOKEN CSRF
        $this->generateToken();

        // ENVOI VERS LE CONTROLEUR PRINCIPAL POUR L'AFFICHAGE
        $this->render("user/formForgetPassword");
    }
    /*
    // ------------------------------------
    //  REINITIALISATION UN MDP
    // ------------------------------------
    public function forgetPassword()
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
                        $majPasswordMail = new Mail();
                        $majPasswordMail->setFirstname($user->firstname);
                        $majPasswordMail->setLastname($user->lastname);
                        $majPasswordMail->setEmail($user->email);
                        $majPasswordMail->setToken($token);
                        $majPasswordMailModel = new MailModel();
                        $success2 = $majPasswordMailModel->mdpForget($majPasswordMail);

                        // VERIFICATION DES ACCUSES DE TRAITEMENT
                        // ENVOI VERS LE CONTROLEUR PRINCIPAL POUR LE RECHARGEMENT
                        $success1 && $success2
                            ? $this->myHeader("Home", "home", "success_email")
                            : $this->myHeader("User", "formForgetPassword", "error_email");
                    } else {

                        // ENVOI VERS LE CONTROLEUR PRINCIPAL POUR LE RECHARGEMENT
                        $this->myHeader("User", "formCreate", "error_noEmail");
                    }
                } else {

                    // ENVOI VERS LE CONTROLEUR PRINCIPAL POUR LE RECHARGEMENT
                    $this->myHeader("User", "formForgetPassword", "error_inputEmail");
                }
            } else {

                // ENVOI VERS LE CONTROLEUR PRINCIPAL POUR LE RECHARGEMENT
                $this->myHeader("User", "formForgetPassword", "error_token");
            }
        }
    }

    // -------------------------------------------------------
    //  AFFICHER UN FORMULAIRE DE REINITIALISATION
    // -------------------------------------------------------
    public function formUpdatePassword()
    {
        // VERIFICATION DU GET
        if ($_GET["token"] ?? null) {

            // CREATION D'UN TOKEN CSRF
            $this->generateToken();

            // LECTURE DE L'CLIENT AVEC LE TOKEN
            $user = new User();
            $user->setToken($_GET["token"]);
            $userModel = new UserModel();
            $user = $userModel->readByToken($user);
            if ($user && ($_GET["token"] === $user->token)) {

                // VERIFICATION DE LA DATE D'EXPIRATION
                // ENVOI VERS LE CONTROLEUR PRINCIPAL POUR L'AFFICHAGE OU LE RECHARGEMENT
                strtotime($user->token_expire) > time()
                    ? $this->render("user/formUpdatePassword")
                    : $this->myHeader("User", "formForgetPassword", "error_expire");
            } else {

                // ENVOI VERS LE CONTROLEUR PRINCIPAL POUR LE RECHARGEMENT
                $this->myHeader("User", "formForgetPassword", "error_link");
            }
        } else {

            // ENVOI VERS LE CONTROLEUR PRINCIPAL POUR LE RECHARGEMENT
            $this->myHeader("Home", "home", "error_id");
        }
    }

    // ----------------------------
    //  MODIFIER LE MDP
    // ----------------------------
    public function updatePassword()
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
                $password = $_POST["password"] ?? null;
                if ($token && $password) {

                    // LECTURE DE L'CLIENT AVEC LE TOKEN
                    $majUser = new User();
                    $majUser->setToken($token);
                    $majUserModel = new UserModel();
                    $user = $majUserModel->readByToken($majUser);

                    // MISE A JOUR DU MDP
                    $majUser->setEmail($user->email);
                    $majUser->setPassword($password);
                    $majUser->setToken(null); // Réinitialisation du token
                    $majUser->setToken_expire(null); // Réinitialisation de la date d'expiration
                    $success = $majUserModel->updatePassword($majUser);

                    // VERIFICATION DE L'ACCUSE DE TRAITEMENT
                    // ENVOI VERS LE CONTROLEUR PRINCIPAL POUR LE RECHARGEMENT
                    $success
                        ? $this->myHeader("User", "formLogin", "success_updatePassword")
                        : $this->myHeader("User", "formUpdatePassword", "error_request");
                } else {

                    // ENVOI VERS LE CONTROLEUR PRINCIPAL POUR LE RECHARGEMENT
                    $this->myHeader("User", "formUpdatePassword", "error_input");
                }
            } else {

                // ENVOI VERS LE CONTROLEUR PRINCIPAL POUR LE RECHARGEMENT
                $this->myHeader("User", "formUpdatePassword", "error_token");
            }
        }
    }
*/
    // -----------------------------------------------
    //  AFFICHER UN FORMULAIRE DE CREATION
    // -----------------------------------------------
    public function formSignUp()
    {
        // CREATION D'UN TOKEN CSRF
        $this->generateToken();

        // ENVOI VERS LE CONTROLEUR PRINCIPAL POUR L'AFFICHAGE
        $data = [
            "scripts" => ["type='module' src='../public/js/formSignup.js'"]
        ];
        $this->render("user/formSignup", $data);
    }

    // ----------------------------
    //  CREER UN CLIENT
    // ----------------------------
    public function create()
    {
        $redirect = null;
        $message = "";
        $success = false;

        // VERIFICATION DE LA METHODE POST
        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            //todo TOKEN
            // VERIFICATION DU TOKEN
            // $token = $_POST["token"] ?? "";
            // if ((hash_equals($_SESSION["token"]["id"], $token)) && (time() < $_SESSION["token"]["token_expiration"])) {

            //     // SUPPRESSION DU TOKEN
            //     unset($_SESSION["token"]);
            if (true) {

                // VERIFICATION DES CHAMPS
                $pseudo = $_POST["pseudo"] ?? null;
                $email = $_POST["email"] ?? null;
                $password = $_POST["password"] ?? null;
                $type = $_POST["type"] ?? null;

                if ($pseudo && $email && $password && $type) {

                    // CREATION D'UN CLIENT
                    $user = new User();
                    $user->setPseudo($pseudo);
                    $user->setEmail($email);
                    $user->setPassword($password);
                    $user->setType($type);

                    $userModel = new UserModel();
                    $success = $userModel->create($user);

                    if ($success === true) {
                        // SUCCES : REDIRECTION VERS LA PAGE LOGIN
                        $message = "Félicitations, vous êtes des notres ! Connectez vous maintenant...";
                        $redirect = "index.php?controller=User&action=formLogin&success=" . true . "&message=" . urlencode($message);
                    } else {
                        if ($success === 1062) {
                            $message = "Le pseudo ou l'adresse mail existe déja.";
                        } else {
                            $message = "Unexpected error occured. Please try later.";
                        }
                    }
                } else {
                    $message = "Tous les champs du formulaire doivent être remplis.";
                }
            } else {
                $message = "Token error.";
            }
        } else {
            $message = "Internal error.";
        }

        // Sortie commune à tous les cas de figure
        echo json_encode([
            "redirect" => $redirect,
            "message" => $message,
            "success" => $success
        ]);
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
                $user = new User();
                $user->setId_user($_GET["id_user"]);
                $userModel = new UserModel();
                $user = $userModel->readById($user);

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
                    $password = $_POST["password"] ?? ""; // Le mot de passe peut être nul.
                    $statut = $_POST["statut"] ?? "user"; // Statut user minimum
                    if ($id_user && $firstname && $lastname && $email) {

                        // MISE A JOUR DE L'CLIENT
                        $majUser = new User();
                        $majUser->setId_user($id_user);
                        $majUser->setFirstname($firstname);
                        $majUser->setLastname($lastname);
                        $majUser->setEmail($email);
                        $majUser->setPassword($password);
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
