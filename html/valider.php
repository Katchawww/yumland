<?php
session_start();
include("fonctions.php");
require("getapikey.php");

// sécurité si pas connecté ou panier vide
if(!isset($_SESSION["user"]) || empty($_SESSION["panier"])){
    header("Location: panier.php");
    exit;
}

$user = $_SESSION["user"];
$panier = $_SESSION["panier"];

// charger les commandes existantes pour générer un ID unique
$orders = readData("json/commandes.json");

// on génère un ID unique pour la nouvelle commande
$id = 1;
if(!empty($orders)){
    $ids = array_column($orders, "id");
    $id = max($ids) + 1;
}

// on recupere la date de livraison choisie par l'utilisateur
$date = $_POST["date"];

// on charge les produits pour calculer le total de la commande
$produits = readData("json/plats.json");
$menus = readData("json/menus.json");
$total = 0;

foreach($panier as $item){
    foreach($produits as $p){
        if($p["id"] == $item["dish"]){
            $total += $p["price"] * $item["qty"];
        }
    }
    foreach($menus as $m){
        if($m["id"] == $item["dish"]){
            $total += $m["price"] * $item["qty"];
        }
    }
}

// appliquer la remise fidélité
$remise = $_SESSION["user"]["remise"] ?? "aucun";
$montantRemise = 0;
if($remise == "5%"){
    $montantRemise = $total * 0.05;
}
elseif($remise == "10%"){
    $montantRemise = $total * 0.10;
}
$total = $total - $montantRemise;

// créer commande avec statut "en_attente_paiement" et livreur "aucun"
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

// on ajoute la nouvelle commande à la liste des commandes
$orders[] = $newOrder;


//CYBANK avec génération d'un id unique pour la transaction
$transaction = "CMD" . $id .time();
$montant = number_format($total, 2, '.', '');
$vendeur = "SUPMECA_A";
$retour = "http://localhost:1234/retour.php";

$api_key = getAPIKey($vendeur);

// Signature pour sécuriser la requête de paiement
$control = md5(
    $api_key . "#" .
    $transaction . "#" .
    $montant . "#" .
    $vendeur . "#" .
    $retour . "#"
);

// sauvegarde de la commande
saveData("json/commandes.json", $orders);
// on supprime le panier et le token CSRF de la session pour éviter les erreurs si l'utilisateur revient sur le panier après validation
unset($_SESSION['csrf']);
unset($_SESSION["panier"]);
?>

<!-- redirection automatique vers la plateforme de paiement avec les données nécessaires -->
<form id="payForm" action="https://www.plateforme-smc.fr/cybank/index.php" method="POST">
    <input type="hidden" name="transaction" value="<?= htmlspecialchars($transaction) ?>">
    <input type="hidden" name="montant" value="<?= $montant ?>">
    <input type="hidden" name="vendeur" value="<?= $vendeur ?>">
    <input type="hidden" name="retour" value="<?= $retour ?>">
    <input type="hidden" name="control" value="<?= $control ?>">
</form>


<script>
// redirection automatique vers la plateforme de paiement
document.getElementById("payForm").submit();
</script>