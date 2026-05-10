<?php
session_start();
include("fonctions.php");

if(!isset($_SESSION["user"])){
    header("Location: connexion.php");
    exit;
}

$produits = readData("json/plats.json");

if(!isset($_SESSION["panier"])){
    $_SESSION["panier"] = [];
}

// ajouter produit
if(isset($_POST["dish"])){

    $_SESSION["panier"][] = [
        "dish" => intval($_POST["dish"]),
        "qty" => intval($_POST["qty"])
    ];
}

// supprimer produit
if(isset($_GET["remove"])){
    unset($_SESSION["panier"][$_GET["remove"]]);
}

$panier = $_SESSION["panier"];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Nos plats – Copa Cabanane 🍌</title>
    <link id="theme-style" rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/jpg" href="images/favicon.jpg">
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
</head>
<body>

<!-- HEADER -->
<header class="header">
    <img src="images/logo-copa-cabanane.png" alt="Logo Copa Cabanane">
    <img src="https://static.vecteezy.com/system/resources/previews/031/122/692/non_2x/france-and-brazil-flags-two-flags-vector.jpg" alt="Drapeaux France et Brésil" style="height: 100px; margin-left: 20px; border-radius: 5px; width: 350px;">


    <nav>
        <a href="index.php">Accueil</a>
        <a href="produits.php">Plats</a>
        <a href="profil.php">Profil</a>
        <a href="deconnexion.php">Déconnexion</a>
    </nav>
</header>
<body>
<section class="cards">
<div>
<h1>🛒 Mon panier</h1>
</div>

<?php if(empty($panier)){ ?>
    <p>Panier vide</p>
<?php } else { ?>
<table cellpadding="10">
<tr>
    <th>Produit</th>
    <th>Prix</th>
    <th>Quantité</th>
    <th>Total</th>
    <th>Action</th>
</tr>

<?php
$totalGeneral = 0;

foreach($panier as $index => $item){

    foreach($produits as $p){
        if($p["id"] == $item["dish"]){
            $nom = $p["name"];
            $prix = $p["price"];
        }
    }

    $total = $prix * $item["qty"];
    $totalGeneral += $total;
?>

<tr>
    <td><?php echo $nom; ?></td>
    <td><?php echo $prix; ?> €</td>
    <td><?php echo $item["qty"]; ?></td>
    <td><?php echo $total; ?> €</td>
    <td>
        <a href="panier.php?remove=<?php echo $index; ?>"onclick="return confirm('Supprimer ce produit ?')">❌</a>
    </td>
</tr>

<?php } ?>

</table>

<h3>Total : <?php echo $totalGeneral; ?> €</h3>

<form method="POST" action="valider.php">
    <label>Date de livraison :</label>
    <input type="datetime-local" name="date" required>

    <br><br>
    <button type="submit">✅ Valider commande</button>
</form>

<?php } ?>
</section>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<!-- FOOTER -->
<footer>
    © 2026 – Copa Cabanane 🍌
    <nav>
        <p>Contact us:
        <a href="https://mail.google.com/mail/u/0/?hl=fr#inbox?compose=new">📧 contactcopacabanane@gmail.com</a>
        | <a href="https://www.instagram.com"> Instagram</a>
         | <a href="https://www.tiktok.com/fr/">Tiktok</a></p> 
    </nav>  
</footer>

<script src="js/theme.js"></script>
</body>
</html>