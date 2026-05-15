<?php
session_start();
include("fonctions.php");
checkBlocked();

// sécurité
if(!isset($_SESSION["user"])){
    header("Location: connexion.php");
    exit;
}

if($_SESSION["user"]["role"] != "restaurateur" && $_SESSION["user"]["role"] != "admin"){
    exit("Accès refusé");
}

$orders = readData("json/commandes.json");
$livreurs = readData("json/livreurs.json");

// récupérer commande
if(!isset($_GET["id"])){
    echo "Aucune commande sélectionnée";
    exit;
}

$id = intval($_GET["id"]);

foreach($orders as $o){
    if($o["id"] == $id){
        $order = $o;
        break;
    }
}

// sécurité
if(!isset($order)){
    echo "Commande introuvable";
    exit;
}

// traitement formulaire
if(isset($_POST["status"])){

    $newOrders = [];

    foreach($orders as $o){

        if($o["id"] == $id){
            $o["status"] = $_POST["status"];
            $o["livreur"] = $_POST["livreur"];
        }

        $newOrders[] = $o;
    }

    if($_POST["status"] == "en livraison" && $_POST["livreur"] == "aucun" ){
        die("Choisissez un livreur");
    }
    if ($_POST["status"] != "prete" && $_POST["livreur"] != "aucun"
    ){
        die("Le livreur ne peut être attribué que si la commande est prete à être livrée");
    }

    saveData("json/commandes.json", $newOrders);
    header("Location: restauration.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Copa Cabanane 🍌</title>
    <link id="theme-style" rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/jpg" href="images/favicon.jpg">
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
</head>

<header class="header">
    <img src="images/logo-copa-cabanane.png" alt="Logo Copa Cabanane">
    <img src="https://static.vecteezy.com/system/resources/previews/031/122/692/non_2x/france-and-brazil-flags-two-flags-vector.jpg" 
    alt="Drapeaux France et Brésil" style="height: 100px; margin-left: 20px; border-radius: 5px; width: 350px;">
    <nav>
        <a href="index.php" title="aller à l'accueil">Accueil</a>
        <a href="restauration.php" title="retour">Restauration</a>
        <a href="index.php" title="se deconnecter">Déconnexion</a>
    </nav>
</header>
<section>
<h2>✏️ Modifier commandes</h2>

<form method="POST">
<input type="hidden" name="csrf" value="<?= generateCSRF(); ?>">

    <label><b><p>Status :</p></b></label>
    <select name="status">
        <option value="payee" <?php if($order["status"]=="payee") echo "selected"; ?>>payée</option>
        <option value="preparation" <?php if($order["status"]=="preparation") echo "selected"; ?>>en préparation</option>
        <option value="prete" <?php if($order["status"]=="prete") echo "selected"; ?>>prête</option>
        <option value="en livraison" <?php if($order["status"]=="en livraison") echo "selected"; ?>>en livraison</option>
        <option value="livree" <?php if($order["status"]=="livree") echo "selected"; ?>>livrée</option>
    </select><br>

    <label><b><p>Attribuer à un livreur :</p></b></label>
    <select name="livreur">
    <option value="aucun">aucun</option>

    <?php foreach($livreurs as $l){ ?>
        <option value="<?php echo htmlspecialchars($l["name"]); ?>"
            <?php if(isset($order["livreur"]) && $order["livreur"] == $l["login"]) echo "selected"; ?>>
            <?php echo $l["name"]; ?>
        </option>
    <?php } ?>
    </select><br><br>

    <button type="submit">💾 Enregistrer</button>

</form>
</section>
<script src="js/theme.js"></script>
</body>

<footer>
    <p>© 2026 – Copa Cabanane 🍌 | Soleil dans l’assiette </p>
    <nav>
    <p>Contact :
    <a href="mailto:contactcopacabanane@gmail.com">📧 contactcopacabanane@gmail.com</a>
    | <a href="https://www.instagram.com"> Instagram</a>
     | <a href="https://www.tiktok.com/fr/">Tiktok</a></p> 
    </nav>  
</footer>
</html>
