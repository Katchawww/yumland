<?php
session_start();
include("fonctions.php");
require("getapikey.php");

// récupérer données CYBank
$transaction = $_GET['transaction'] ?? null;
$montant = $_GET['montant'] ?? null;
$vendeur = $_GET['vendeur'] ?? null;
$status = $_GET['status'] ?? null;
$control = $_GET['control'] ?? null;

// sécurité basique pour éviter les erreurs si on accède à cette page sans passer par CYBank
if(!$transaction || !$montant || !$vendeur || !$status || !$control){
    die("Paramètres manquants");
}

// récupérer clé API
$api_key = getAPIKey($vendeur);

// recalcul du hash
$control_check = md5(
    $api_key . "#" .
    $transaction . "#" .
    $montant . "#" .
    $vendeur . "#" .
    $status . "#"
);

// vérification antifraude
if($control_check !== $control){
    die("❌ Erreur de sécurité : hash invalide");
}

// charger commandes existantes
$orders = readData("json/commandes.json");
// mise a jour de la commande correspondante si paiement accepté
foreach($orders as &$o){
    if(
        $status === "accepted" && strpos($transaction, "CMD".$o["id"]) === 0
    ){
        $o["status"] = "payee";
        $o["paiements"][] = $montant;
    }
}

// sauvegarde des modifs
saveData("json/commandes.json", $orders);
if($status === "accepted"){
    //on nettoie le panier après le paiment réussi
    unset($_SESSION["panier"]);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Résultat du paiement</title>
    <link id="theme-style" rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/jpg" href="images/favicon.jpg">
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
</head>

<!-- Haut de page -->
<header class="header">
    <img src="images/logo-copa-cabanane.png" alt="Logo Copa Cabanane">
    <img src="https://static.vecteezy.com/system/resources/previews/031/122/692/non_2x/france-and-brazil-flags-two-flags-vector.jpg" alt="Drapeaux France et Brésil" style="height: 100px; margin-left: 20px; border-radius: 5px; width: 350px;">

    <nav>
        <a href="index.php">Accueil</a>
    </nav>
</header>

<body>
<section>
<h1>
<?php if($status === "accepted"){ ?>
    ✅ Paiement accepté !
<?php } else { ?>
    ❌ Paiement refusé
<?php } ?>
</h1>

<!-- Affichage des détails de la transaction pour le client -->
<p>Transaction : <?php echo htmlspecialchars($transaction); ?></p>
<p>Montant : <?php echo htmlspecialchars($montant); ?> €</p>
<br>

<nav><a href="profil.php">➡️ Voir mes commandes</a></nav>
</section>


<footer>
    © 2026 – Copa Cabanane 🍌
    <nav>
        <p>Contact :
        <a href="mailto:contactcopacabanane@gmail.com">📧 contactcopacabanane@gmail.com</a>
        | <a href="https://www.instagram.com"> Instagram</a>
         | <a href="https://www.tiktok.com/fr/">Tiktok</a></p> 
    </nav>  
</footer>

<script src="js/theme.js"></script>
</body>
</html>