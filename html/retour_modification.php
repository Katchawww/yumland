<?php
session_start();
include("fonctions.php");

// on vérifie les parametres nécessaires
if(
    !isset($_GET["id"]) ||
    !isset($_GET["status"]) ||
    !isset($_GET["montant"])
){
    exit("Erreur");
}

// id de la commande modifiée
$id =intval($_GET["id"]);

// statut du paiement renvoyé par la plateforme de paiement
$status = $_GET["status"] ?? "";

// montant de la modification sécurise par default à 0 pour éviter les erreurs
$montant = $_GET["montant"] ?? 0;

// on charge les commandes
$orders = readData("json/commandes.json");

// on met à jour la commande avec le nouveau paiement si accepté
foreach($orders as &$o){
    if($o["id"] == $id){
        if($status == "accepted"){
            $o["paiements"][] = $montant;
        }
    }
}

// on enregistre les modifications
saveData("json/commandes.json",$orders);

// on supprime la différence de paiement de la session pour éviter les erreurs si l'utilisateur modifie à nouveau sa commande
unset($_SESSION["difference"]);
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Paiement modification</title>
<link id="theme-style" rel="stylesheet" href="css/style.css">
</head>

<body>

<section>

<h1>
<?php if($status == "accepted"){ ?>
✅ Paiement supplémentaire accepté
<?php } else { ?>
❌ Paiement refusé
<?php } ?>
</h1>

<nav><a href="profil.php"> Retour profil </a></nav>
</section>

<script src="js/theme.js"></script>
</body>
</html>