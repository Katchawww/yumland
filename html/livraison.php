<?php
session_start();
include("fonctions.php");

// sécurité
if(!isset($_SESSION["user"])){
    header("Location: connexion.php");
    exit;
}

$user = $_SESSION["user"];

// vérifier que c'est un livreur
if($user["role"] != "livreur"){
    echo "Accès refusé";
    exit;
}

$orders = readData("json/commandes.json");
$clients = readData("json/utilisateurs.json");
$produits = readData("json/plats.json");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Livraison – Copa Cabanane 🍌</title>

    <link rel="icon" type="image/jpg" href="images/favicon.jpg">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<!-- HEADER -->
<header class="header">
    <img src="images/logo-copa-cabanane.png" alt="Logo Copa Cabanane">
    <img src="https://static.vecteezy.com/system/resources/previews/031/122/692/non_2x/france-and-brazil-flags-two-flags-vector.jpg" alt="Drapeaux France et Brésil" style="height: 100px; margin-left: 20px; border-radius: 5px; width: 350px;">

    <nav>
        <a href="index.php">Accueil</a>
        <a href="livraison.php">Livraison</a>
        <a href="deconnexion.php">Déconnexion</a>
    </nav>
</header>


<section>
<h1>🚚 Espace Livreur</h1>

<?php foreach($orders as $order){ ?>

    <?php if($order["livreur"] == $user["login"]){ ?>

        <div class="card">
            <p><b>Commande #<?php echo $order["id"]; ?></b></p>
            <p><b>Client :</b> <?php echo $order["client"]; ?></p>
            <p><b>Statut :</b> <?php echo $order["status"]; ?></p>

            <ul>
                <?php foreach($order["items"] as $item){ ?>
                    <?php
                        $nomProduit = "Inconnu";

                        foreach($produits as $p){
                            if($p["id"] == $item["dish"]){
                                $nomProduit = $p["name"];
                            }
                        }
                        ?>

                <li><?php echo $nomProduit; ?> (x<?php echo $item["qty"]; ?>)</li>
                <?php } ?>
            </ul>

            <?php
                $clientInfo = null;

                foreach($clients as $client){
                    if($client["login"] == $order["client"]){
                        $clientInfo = $client;
                    }
                }
            ?>

            <p><b>Client :</b> <?php echo $clientInfo["name"] . " " . $clientInfo["surname"]; ?></p>
            <p><b>Téléphone :</b> <?php echo $clientInfo["phone"]; ?></p>
            <p><b>Adresse :</b> <?php echo $clientInfo["address"]; ?></p>

            <nav><a href="https://www.google.com/maps/search/<?php echo urlencode($clientInfo["address"]); ?>" target="_blank">
            📍 Afficher sur la carte</a></nav>
                                                

            <!-- bouton livrer -->
            <?php if($order["status"] != "livree"){ ?>
                <nav><a href="livrer.php?id=<?php echo $order["id"]; ?>">✅ Marquer comme livrée</a></nav>
            <?php } ?>

        </div>

    <?php } ?>

<?php } ?>
</section>
<br><br>

<!-- FOOTER -->
<footer>
    © 2026 – Copa Cabanane 🍌
</footer>

</body>
</html>
