<?php
session_start();
include("fonctions.php");

if(
    !isset($_GET["id"]) ||
    !isset($_GET["status"]) ||
    !isset($_GET["montant"])
){
    exit("Erreur");
}

$id =intval($_GET["id"]);

$status = $_GET["status"] ?? "";

$montant = $_GET["montant"] ?? 0;

$orders = readData("json/commandes.json");

foreach($orders as &$o){
    if($o["id"] == $id){
        if($status == "accepted"){
            $o["paiements"][] = $montant;
        }
    }
}

saveData("json/commandes.json",$orders);

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