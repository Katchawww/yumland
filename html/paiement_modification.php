<?php
session_start();
require("getapikey.php");

// on vérifie que l'utilisateur est connecté
if(!isset($_SESSION["user"])){
    exit("Accès interdit");
}

// on verifie que le montant de la modification existe
if(!isset($_SESSION["difference"])){
    exit("Erreur");
}

// on vérifie que l'id de la commande à modifier est présent dans l'URL
if(!isset($_GET["id"])){
    exit("Erreur");
}
$id = intval($_GET["id"]);
if($id <= 0){
    exit("Erreur");
}

// on vérifie que le montant de la modification est positif
$difference = floatval($_SESSION["difference"]);
if($difference <= 0){
    exit("Montant invalide");
}
// on génère une transaction unique pour cette modification
$transaction = "MODIF".$id.time();

// on formate le montant avec 2 décimales et un point comme séparateur
$montant =number_format($difference, 2,'.', '');

// vendeur fixe pour notre application
$vendeur ="SUPMECA_A";

// URL de retour après paiement
$retour ="http://localhost:1234/retour_modification.php?id=".$id;

// on récupère la clé API du vendeur
$api_key = getAPIKey($vendeur);

// on génère le hash de contrôle pour sécuriser la requête
$control = md5(
    $api_key . "#" .
    $transaction . "#" .
    $montant . "#" .
    $vendeur . "#" .
    $retour . "#"
);
?>

<!-- redirection automatique vers la plateforme de paiement avec les données nécessaires -->
<form id="payForm" action="https://www.plateforme-smc.fr/cybank/index.php" method="POST">
    <!-- identifiants de la transaction -->
    <input type="hidden" name="transaction" value="<?= htmlspecialchars($transaction) ?>">
    <!-- montant à payer pour la modification -->
    <input type="hidden" name="montant" value="<?= $montant ?>">
    <!-- identifiant du vendeur-->
    <input type="hidden" name="vendeur" value="<?= $vendeur ?>">
    <!-- URL de retour après paiement -->
    <input type="hidden" name="retour" value="<?= $retour ?>">
    <!-- hash de contrôle pour sécuriser la requête -->
    <input type="hidden" name="control" value="<?= $control ?>">
</form>

<script>
// soumission automatique du formulaire pour rediriger vers la plateforme de paiement
document.getElementById("payForm").submit();
</script>