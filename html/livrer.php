<?php
session_start();
include("fonctions.php");

// sécurité connexion
if(!isset($_SESSION["user"])){
    header("Location: connexion.php");
    exit;
}

$user = $_SESSION["user"];

// sécurité rôle
if($user["role"] != "livreur"){
    echo "Accès refusé";
    exit;
}

// vérifier ID
if(!isset($_GET["id"])){
    echo "ID manquant";
    exit;
}

$id = $_GET["id"];

// charger commandes
$orders = readData("json/commandes.json");

$newOrders = [];
$found = false;

foreach($orders as $order){

    // vérifier bonne commande ET bon livreur
    if($order["id"] == $id && $order["livreur"] == $user["login"]){
        $order["status"] = "livree";
        $found = true;
    }

    $newOrders[] = $order;
}

// si commande non trouvée
if(!$found){
    echo "Commande introuvable ou non autorisée";
    exit;
}

// sauvegarde
file_put_contents("json/commandes.json", json_encode($newOrders, JSON_PRETTY_PRINT));

// redirection
header("Location: livraison.php");
exit;
?>