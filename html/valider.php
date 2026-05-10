<?php
session_start();
include("fonctions.php");
require("getapikey.php");

// sécurité
if(!isset($_SESSION["user"]) || empty($_SESSION["panier"])){
    header("Location: panier.php");
    exit;
}

$user = $_SESSION["user"];
$panier = $_SESSION["panier"];


$orders = readData("json/commandes.json");

// ID unique
$id = 1;
if(!empty($orders)){
    $ids = array_column($orders, "id");
    $id = max($ids) + 1;
}

// date
$date = $_POST["date"];


$produits = readData("json/plats.json");
$total = 0;

foreach($panier as $item){
    foreach($produits as $p){
        if($p["id"] == $item["dish"]){
            $total += $p["price"] * $item["qty"];
        }
    }
}

// créer commande (statut modifié)
$newOrder = [
    "id" => $id,
    "client" => $user["login"],
    "status" => "en_attente_paiement",
    "date" => $date,
    "items" => $panier,
    "livreur" => "aucun",
    "total" => $total,
    "paiements"=> []
];

$orders[] = $newOrder;

saveData("json/commandes.json", $orders);



//CYBANK

$transaction = "CMD" . $id .time();
$montant = number_format($total, 2, '.', '');
$vendeur = "SUPMECA_A";
$retour = "http://localhost:1234/retour.php";

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
    <input type="hidden" name="transaction" value="<?= $transaction ?>">
    <input type="hidden" name="montant" value="<?= $montant ?>">
    <input type="hidden" name="vendeur" value="<?= $vendeur ?>">
    <input type="hidden" name="retour" value="<?= $retour ?>">
    <input type="hidden" name="control" value="<?= $control ?>">
</form>

<script>
document.getElementById("payForm").submit();
</script>