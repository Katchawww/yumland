<?php
session_start();
require("getapikey.php");
if(!isset($_SESSION["user"])){
    exit("Accès interdit");
}

if(!isset($_SESSION["difference"])){
    exit("Erreur");
}

if(!isset($_GET["id"])){
    exit("Erreur");
}
$id = intval($_GET["id"]);
if($id <= 0){
    exit("Erreur");
}

$difference = floatval($_SESSION["difference"]);
if($difference <= 0){
    exit("Montant invalide");
}

$transaction = "MODIF".$id.time();



$montant =number_format($difference, 2,'.', '');

$vendeur ="SUPMECA_A";

$retour ="http://localhost:1234/retour_modification.php?id=".$id;

$api_key = getAPIKey($vendeur);

$control = md5(
    $api_key . "#" .
    $transaction . "#" .
    $montant . "#" .
    $vendeur . "#" .
    $retour . "#"
);
?>

<form id="payForm" action="https://www.plateforme-smc.fr/cybank/index.php" method="POST">
    <input type="hidden" name="transaction" value="<?= htmlspecialchars($transaction) ?>">
    <input type="hidden" name="montant" value="<?= $montant ?>">
    <input type="hidden" name="vendeur" value="<?= $vendeur ?>">
    <input type="hidden" name="retour" value="<?= $retour ?>">
    <input type="hidden" name="control" value="<?= $control ?>">
</form>

<script>
document.getElementById("payForm").submit();
</script>