<?php session_start();
include("fonctions.php");

// Sécurité : si pas connecté → redirection
if(!isset($_SESSION["user"])){
    header("Location: connexion.php");
    exit;
}

$user = $_SESSION["user"];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Administration – Copa Cabanane 🍌</title>

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
        <a href="restauration.php">Restauration</a>
        <a href="index.php">Déconnexion</a>
    </nav>
</header>

<!-- ADMIN -->
<section>
    <h1>Restauration</h1>
    <p>Gestion des commandes du site</p>
    <br><br>

    <!-- UTILISATEURS -->
    <div class="card">
        <h2>🧾 Listes des commandes</h2>
    
    <?php
    $users = readData("json/utilisateurs.json");
    $orders = readData("json/commandes.json");
    ?>


    <?php foreach($orders as $order){ ?>

        <?php echo "<div class='card'>";?>
        <?php echo "<p>Commande #" . $order["id"] . "</p>";?>
        <?php  echo "<p>Client : " . $order["client"] . "</p>";?>
        <?php   echo "<p>Statut : " . $order["status"] . "</p>";?>
        <?php  echo "<ul>";?>
        <?php foreach($order["items"] as $item){?>
            <?php  echo "<li>Produit ID : ".$item["dish"]. "(x".$item["qty"].")</li>";?><?php } ?>
            <?php echo "</ul>";?>
            <nav><a href="etatcommandes.php?id=<?php echo $order["id"]; ?>">✏️ Modifier</a></nav>
            <?php echo "</div>";?>
      <?php } ?>
</section>


<br><br><br><br><br><br>

<!-- FOOTER -->
<footer>
    © 2026 – Copa Cabanane 🍌
</footer>

</body>
</html>
