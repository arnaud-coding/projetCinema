<!DOCTYPE html>
<html lang="fr">

<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333333;">
  <div style="max-width: 600px; margin: auto; padding: 20px; border: 1px solid #ddd; border-radius: 10px; background-color: #f9f9f9;">
    <img style="max-width: 100%; height: auto;" src="cid:font" alt="Image">
    <h2 style="color: #4CAF50;">Bonjour <?php echo htmlspecialchars("$prenomNom", ENT_QUOTES, "UTF-8"); ?>,</h2>
    <p>Merci pour votre commande sur CEFiiMarket ! Nous sommes ravis de vous compter parmi nos clients.</p>
    <p><strong>Détails de votre commande :</strong></p>
    <p><strong>Numéro de votre commande: </strong><?php echo htmlspecialchars($num_commande, ENT_QUOTES, "UTF-8") ?></p>
    <p><strong>Date de commande : </strong><?php echo htmlspecialchars($date_commande, ENT_QUOTES, "UTF-8") ?></p>
    <p><strong>Montant de votre commande : </strong><?php echo htmlspecialchars($montant_commande, ENT_QUOTES, "UTF-8") ?> €</p>
    <p><strong>Adresse de livraison :</strong><?php echo htmlspecialchars($adresse_livraison, ENT_QUOTES, "UTF-8") ?></p>
    <p><strong>Suivi de livraison :</strong></p>
    <p>Votre commande est en cours de préparation par nos équipes et sera expédiée sous 5 jours. Vous recevrez un e-mail avec un lien de suivi dès qu'elle sera expédiée.</p>
    <p>Merci encore pour votre confiance ! À très bientôt sur CEFiiMarket.</p>
    <p>L'équipe CEFiiMarket</p>
    <hr style="border: 0; border-top: 1px solid #ddd;">
    <small style="font-size: 12px; color: #888;">
      Si vous avez des questions, veuillez nous contacter à l'adresse support@cefiimarket.fr.<br>
      Cet email a été envoyé automatiquement, merci de ne pas y répondre.
    </small>
  </div>
</body>

</html>