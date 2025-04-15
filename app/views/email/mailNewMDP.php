<!DOCTYPE html>
<html lang="fr">

<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333333;">
    <div style="max-width: 600px; margin: auto; padding: 20px; border: 1px solid #ddd; border-radius: 10px; background-color: #f9f9f9;">
        <img style="max-width: 100%; height: auto;" src="cid:font" alt="Image">
        <h2 style="color: #4CAF50;">Bonjour <?php echo htmlspecialchars("$prenomNom", ENT_QUOTES, "UTF-8"); ?>,</h2>
        <p>Nous avons reçu une demande pour réinitialiser votre mot de passe. Si vous êtes à l'origine de cette demande, veuillez cliquer sur le lien ci-dessous pour créer un nouveau mot de passe :</p>
        <p style="text-align: center;">
            <a style="display: inline-block; padding: 10px 20px; font-size: 16px; color: #fff; background-color: #4CAF50; text-decoration: none; border-radius: 5px;"
                href="https://www.cefii-developpements.fr/olivier1422/ecf/ecf2/public/index.php?controller=Utilisateur&action=formUpdateMdp&token=<?php echo htmlspecialchars($token, ENT_QUOTES, "UTF-8"); ?>">
                Réinitialiser mon mot de passe
            </a>
        </p>
        <p>Ce lien est valide pendant 1 heure. Passé ce délai, vous devrez effectuer une nouvelle demande.</p>
        <p>Si vous n'êtes pas à l'origine de cette demande, veuillez ignorer cet email. Votre mot de passe actuel restera inchangé.</p>
        <p>Merci,</p>
        <p>L'équipe Ma Bibliothèque</p>
        <hr style="border: 0; border-top: 1px solid #ddd;">
        <small style="font-size: 12px; color: #888;">
            Si vous avez des questions, veuillez nous contacter à l'adresse support@mabibliotheque.fr.<br>
            Cet email a été envoyé automatiquement, merci de ne pas y répondre.
        </small>
    </div>
</body>

</html>