<?php
session_start();
include("fonctions.php");

// sécurité
if(!isset($_SESSION["user"])){
    header("Location: connexion.php");
    exit;
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
    <link rel="stylesheet" href="css/style.css">
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

    <label><b>Status :</label></b><br>
    <select name="status">
         <option <?php if($order["status"]=="preparation") echo "selected"; ?>>preparation</option>
         <option <?php if($order["status"]=="en attente du livreur") echo "selected"; ?>>en attente du livreur</option>
         <option <?php if($order["status"]=="en livraison") echo "selected"; ?>>en livraison</option>
         <option <?php if($order["status"]=="livree") echo "selected"; ?>>livrée</option>
    </select><br><br>

    <label><b>Attribuer à un livreur :</label></b><br>
    <select name="livreur">
    <option value="aucun">aucun</option>

    <?php foreach($livreurs as $l){ ?>
        <option value="<?php echo $l["login"]; ?>"
            <?php if(isset($order["livreur"]) && $order["livreur"] == $l["login"]) echo "selected"; ?>>
            <?php echo $l["name"]; ?>
        </option>
    <?php } ?>
    </select><br><br>

    <button type="submit">💾 Enregistrer</button>

</form>
</section>
</body>

<footer>
    <p>© 2026 – Copa Cabanane 🍌 | Soleil dans l’assiette </p>
    <nav>
    <p>Contact us:
    <a href="https://mail.google.com/mail/u/0/?hl=fr#inbox?compose=new">📧 contactcopacabanane@gmail.com</a>
    | <a href="https://www.instagram.com"> Instagram</a>
     | <a href="https://www.tiktok.com/fr/">Tiktok</a></p> 
    </nav>  
</footer>

</html>
