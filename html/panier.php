<?php
session_start();
include("fonctions.php");
// Vérifie si l'utilisateur est bloqué
checkBlocked();

// Sécurité l'utilisateur doit etre connecté obligatoirement
if(!isset($_SESSION["user"])){
    header("Location: connexion.php");
    exit;
}

// On récupère les produits
$produits = readData("json/plats.json");

// Créer panier dans session si y'en a pas encore
if(!isset($_SESSION["panier"])){
    $_SESSION["panier"] = [];
}

// ajouter produits au panier
if(isset($_POST["dish"])){

    $_SESSION["panier"][] = [
        "dish" => intval($_POST["dish"]),
        "qty" => intval($_POST["qty"]),
    ];
    // Suppression token CSRF après utilisation
    unset($_SESSION['csrf']);

}

// supprimer produit du panier
if(isset($_GET["remove"])){

    // quel produit supprimer
    $index = intval($_GET["remove"]);

    // On regarde si le produit existe dans le panier avant de le supprimer
    if(isset($_SESSION["panier"][$index])){

        // On supprime le produit du panier
        unset($_SESSION["panier"][$index]);
    }
}

// On récupère le panier à afficher
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

<!-- Haut de page -->
<header class="header">
    <img src="images/logo-copa-cabanane.png" alt="Logo Copa Cabanane">
    <img class="flags" src="https://static.vecteezy.com/system/resources/previews/031/122/692/non_2x/france-and-brazil-flags-two-flags-vector.jpg" alt="Drapeaux France et Brésil">

    <nav>
        <a href="index.php">Accueil</a>
        <a href="produits.php">Plats</a>
        <a href="profil.php">Profil</a>
        <a href="deconnexion.php">Déconnexion</a>
    </nav>
</header>

<!-- Section avec elements du panier -->
<section class="cards">
<div>
<h1>🛒 Mon panier</h1>
</div>

<!-- On vérifie si le panier est vide -->
<?php if(empty($panier)){ ?>
    <p>Panier vide</p>
<?php } else { ?>
<!-- On fait un tableau pour afficher les elements du panier -->
<table cellpadding="10">
<tr>
    <th>Produit</th>
    <th>Prix</th>
    <th>Quantité</th>
    <th>Total</th>
    <th>Action</th>
</tr>

<?php
// on initialise le total à 0
$totalGeneral = 0;
$nom = "Produit inconnu";
$prix = 0;

// on parcours les elements du panier
foreach($panier as $index => $item){
    //on regarde les elements associés au produit du panier
    foreach($produits as $p){
        if($p["id"] == $item["dish"]){
            $nom = $p["name"];
            $prix = $p["price"];
        }
    }

    // on calcule le total pour ce produit
    $total = $prix * $item["qty"];
    // ajout au total général
    $totalGeneral += $total;
?>

<tr>
    <td><p><?php echo htmlspecialchars($nom); ?></p></td>
    <td><p><?php echo htmlspecialchars($prix); ?> €</p></td>
    <td><p><?php echo htmlspecialchars($item["qty"]); ?></p></td>
    <td><p><?php echo htmlspecialchars($total); ?> €</p></td>
    <td>
        <a href="panier.php?remove=<?php echo $index; ?>"onclick="return confirm('Supprimer ce produit ?')">❌</a>
    </td>
</tr>

<?php } ?>

</table>

<h3>Total : <?php echo $totalGeneral; ?> €</h3>

<form method="POST" action="valider.php">
    <input type="hidden"  name="csrf"  value="<?php echo generateCSRF(); ?>">
    <label><p>Date de livraison :</p></label>
    <input type="datetime-local" name="date" required>

    <br><br>
    <button type="submit">✅ Valider commande</button>
</form>

<?php } ?>
</section>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

<!-- bas de page -->
<footer>
    © 2026 – Copa Cabanane 🍌
    <nav>
        <p>Contact:
        <a href="mailto:contactcopacabanane@gmail.com">📧 contactcopacabanane@gmail.com</a>
        | <a href="https://www.instagram.com"> Instagram</a>
         | <a href="https://www.tiktok.com/fr/">Tiktok</a></p> 
    </nav>  
</footer>

<script src="js/theme.js"></script>
</body>
</html>