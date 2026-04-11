<?php
session_start();
include("fonctions.php");

$produits = readData("json/plats.json");
$menus = readData("json/menus.json");
$search = $_GET["search"] ?? "";
$categorie = $_GET["categorie"] ?? "";
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Nos plats – Copa Cabanane 🍌</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/jpg" href="images/favicon.jpg">
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
</head>
<body>

<!-- HEADER -->
<header class="header">
    <img src="images/logo-copa-cabanane.png" alt="Logo Copa Cabanane">
    <img src="https://static.vecteezy.com/system/resources/previews/031/122/692/non_2x/france-and-brazil-flags-two-flags-vector.jpg" alt="Drapeaux France et Brésil" style="height: 100px; margin-left: 20px; border-radius: 5px; width: 350px;">


    <nav>
        <a href="index.php" title="aller à l'accueil">Accueil</a>
        <a href="produits.php" title="aller aux plats">Plats</a>
        <?php if(isset($_SESSION["user"])): ?>
            <!-- UTILISATEUR CONNECTÉ -->
            <a href="profil.php">Profil</a>
            <a href="panier.php">Panier</a>
            <a href="deconnexion.php">Déconnexion</a>
        <?php else: ?>
            <!-- UTILISATEUR NON CONNECTÉ -->
            <a href="connexion.php">Connexion</a>
            <a href="inscription.php">Inscription</a>
        <?php endif; ?>
    </nav>
</header>

<!-- TITRE -->
<section class="hero">
    <h1>🍽️ Nos plats</h1>
    <p>Découvrez nos spécialités tropicales</p>
    <?php if($search){ ?>
    <p>Résultats pour : <b><?php echo htmlspecialchars($search); ?></b></p>
<?php } ?>

    <!-- BARRE DE RECHERCHE -->
    <form method="GET" action="produits.php">
        <input type="text" name="search" placeholder="Rechercher un plat...">
    </form>
</section>

<!-- FILTRES -->
<section class="filters">
    <nav><a href="produits.php?categorie=Entrée Do Brazil">🥗 Entrées</a>
    <a href="produits.php?categorie=Plat Do Brazil">🍔 Plats</a>
    <a href="produits.php?categorie=Dessert Do Brazil">🍰 Desserts</a>
    <a href="produits.php?categorie=Boisson Do Brazil">🍹 Boissons</a>
    <a href="produits.php">🍽️ Tous</a>
    <a href="produits.php?categorie=Menu Do Brazil">🍌 Menus</a></nav>
</section>


<!-- LISTE DES PRODUITS -->
<section>
    <h2 textalign: center>Menus Do Brazil</h2>
</section>

<section class="cards">

<?php foreach($menus as $menu){
    if($menu["categorie"] == "Menu Do Brazil" &&(!$search || stripos($menu["name"], $search) !== false )&&( !$categorie || $menu["categorie"] == $categorie)){ ?>
    <div class="product-card">
        <h3><?php echo $menu["name"]; ?></h3>
        <p><b><?php echo $menu["price"]; ?> €</b></p>
        <p><b>Contenu du menu :</b></p>
        <ul>
        <?php
        foreach($menu["plats"] as $id){

            foreach($produits as $p){
                if($p["id"] == $id){
                    echo "<li>".$p["name"]."</li>";
                }
            }

        }
        ?>
        </ul>
        <img src="images/<?php echo $menu["image"]; ?>" alt="<?php echo $menu["name"]; ?>">

        <form method="POST" action="panier.php">
            <input type="hidden" name="dish" value="<?php echo $menu["id"]; ?>">

            Quantité :
            <input type="number" name="qty" value="1" min="1" max="99">

            <button type="submit">🛒 Ajouter</button>
        </form>
    </div>

<?php } }?>
</section>


<section>
    <h2 textalign: center>Entrées Do Brazil</h2>
</section>

<section class="cards">

<?php foreach($produits as $produit){
    if($produit["categorie"] == "Entrée Do Brazil" &&(!$search || stripos($produit["name"], $search) !== false )&&( !$categorie || $produit["categorie"] == $categorie)){ ?>
    <div class="product-card">
        <h3><?php echo $produit["name"]; ?></h3>
        <p><b><?php echo $produit["price"]; ?> €</b></p>
        <img src="images/<?php echo $produit["image"]; ?>" alt="<?php echo $produit["name"]; ?>">

        <form method="POST" action="panier.php">
            <input type="hidden" name="dish" value="<?php echo $produit["id"]; ?>">

            Quantité :
            <input type="number" name="qty" value="1" min="1" max="99">

            <button type="submit">🛒 Ajouter</button>
        </form>
    </div>

<?php } }?>
</section>


<section>
    <h2 textalign: center>Plats Do Brazil</h2>
</section>

<section class="cards">

<?php foreach($produits as $produit){
    if($produit["categorie"] == "Plat Do Brazil"&&(!$search || stripos($produit["name"], $search) !== false )&&( !$categorie || $produit["categorie"] == $categorie)){ ?>
    <div class="product-card">
        <h3><?php echo $produit["name"]; ?></h3>
        <p><b><?php echo $produit["price"]; ?> €</b></p>
        <img src="images/<?php echo $produit["image"]; ?>" alt="<?php echo $produit["name"]; ?>">

        <form method="POST" action="panier.php">
            <input type="hidden" name="dish" value="<?php echo $produit["id"]; ?>">

            Quantité :
            <input type="number" name="qty" value="1" min="1" max="99">

            <button type="submit">🛒 Ajouter</button>
        </form>
    </div>

<?php } }?>
</section>

<section>
    <h2 textalign: center>Dessert Do Brazil</h2>
</section>

<section class="cards">

<?php foreach($produits as $produit){
    if($produit["categorie"] == "Dessert Do Brazil"&&(!$search || stripos($produit["name"], $search) !== false )&&( !$categorie || $produit["categorie"] == $categorie)){ ?>
    <div class="product-card">
        <h3><?php echo $produit["name"]; ?></h3>
        <p><b><?php echo $produit["price"]; ?> €</b></p>
        <img src="images/<?php echo $produit["image"]; ?>" alt="<?php echo $produit["name"]; ?>">

        <form method="POST" action="panier.php">
            <input type="hidden" name="dish" value="<?php echo $produit["id"]; ?>">

            Quantité :
            <input type="number" name="qty" value="1" min="1" max="99">

            <button type="submit">🛒 Ajouter</button>
        </form>
    </div>

<?php } }?>
</section>

<section>
    <h2 textalign: center>Boissons Do Brazil</h2>
</section>

<section class="cards">

<?php foreach($produits as $produit){
    if($produit["categorie"] == "Boisson Do Brazil"&&(!$search || stripos($produit["name"], $search) !== false )&&( !$categorie || $produit["categorie"] == $categorie)){ ?>
    <div class="product-card">
        <h3><?php echo $produit["name"]; ?></h3>
        <p><b><?php echo $produit["price"]; ?> €</b></p>
        <img src="images/<?php echo $produit["image"]; ?>" alt="<?php echo $produit["name"]; ?>">

        <form method="POST" action="panier.php">
            <input type="hidden" name="dish" value="<?php echo $produit["id"]; ?>">

            Quantité :
            <input type="number" name="qty" value="1" min="1" max="99">

            <button type="submit">🛒 Ajouter</button>
        </form>
    </div>

<?php } }?>
</section>

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

</body>
</html>