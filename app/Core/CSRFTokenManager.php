<?php

namespace App\Core;

class CSRFTokenManager
{
    // Nom de la clé de session pour stocker le jeton CSRF
    const CSRF_TOKEN_KEY = 'csrf_token';
    const CSRF_TOKEN_EXPIRE = 'csrf_token_expire';

    /**
     * Génère un nouveau jeton CSRF et le stocke en session
     */
    public static function generateCSRFToken()
    {
        // Génère un nouveau jeton CSRF
        $token = bin2hex(random_bytes(32));
        // Durée d'utilisation du token : 15 minutes (900 secondes)
        $token_expiration = time() + 900;

        // Stocke le jeton et son délai d'expiration en session
        $_SESSION[self::CSRF_TOKEN_KEY] = $token;
        $_SESSION[self::CSRF_TOKEN_EXPIRE] = $token_expiration;

        // Retourne le jeton généré
        return $token;
    }

    /**
     * Vérifie si le jeton CSRF soumis correspond à celui stocké en session
     * Et si le délai d'expiration du token n'est pas dépassé
     */
    public static function validateCSRFToken($submittedToken)
    {
        // Vérifie si le jeton soumis est identique à celui stocké en session
        if (
            isset($_SESSION[self::CSRF_TOKEN_KEY])
            && hash_equals($_SESSION[self::CSRF_TOKEN_KEY], $submittedToken)
            && (time() < $_SESSION[self::CSRF_TOKEN_EXPIRE])
        ) {
            // Le jeton est valide et son délai d'utilisation n'est pas dépassé,
            // On le supprime de la session pour qu'il ne puisse être réutilisé
            unset($_SESSION[self::CSRF_TOKEN_KEY]);
            unset($_SESSION[self::CSRF_TOKEN_EXPIRE]);

            // Retourne vrai pour indiquer que la validation a réussi
            return true;
        } else {
            // Le jeton est invalide ou son délai d'utilisation est dépassé, on retourne faux
            return false;
        }
    }
}
