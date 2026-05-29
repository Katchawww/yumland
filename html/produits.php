<?php
session_start();
include("fonctions.php");

// Chargement des données avec JSON
$produits = readData("json/plats.json");
$menus = readData("json/menus.json");

// Récupération des filtres de recherche
$search = $_GET["search"] ?? "";
$categorie = $_GET["categorie"] ?? "";

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

<!-- Banniere principale -->
<header class="header">
    <img src="images/logo-copa-cabanane.png" alt="Logo Copa Cabanane">
    <img class="flags" src="https://static.vecteezy.com/system/resources/previews/031/122/692/non_2x/france-and-brazil-flags-two-flags-vector.jpg" alt="Drapeaux France et Brésil">


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

<!-- Section Principale -->
<section class="hero">
    <h1>🍽️ Nos plats</h1>
    <p>Découvrez nos spécialités tropicales</p>
    <?php if($search){ ?>
    <p>Résultats pour : <b><?php echo htmlspecialchars($search); ?></b></p>
<?php } ?>

<!-- Barre de recherche -->
    <form method="GET" action="produits.php">
        <input type="text" name="search" placeholder="Rechercher un plat...">
    </form>
</section>

<!-- Filtres par categorie -->
<section class="filters">
    <nav><a href="produits.php?categorie=Entrée Do Brazil">🥗 Entrées</a>
    <a href="produits.php?categorie=Plat Do Brazil">🍔 Plats</a>
    <a href="produits.php?categorie=Dessert Do Brazil">🍰 Desserts</a>
    <a href="produits.php?categorie=Boisson Do Brazil">🍹 Boissons</a>
    <a href="produits.php">🍽️ Tous</a>
    <a href="produits.php?categorie=Menu Do Brazil">🍌 Menus</a></nav>
</section>

<!-- Tri + Allergènes -->
<section class="filters">
    <select id="tri">
        <option value="">- Trier par -</option>

        <option value="prix+">
            Prix croissant
        </option>

        <option value="prix-">
            Prix décroissant
        </option>

        <option value="tri-nom">
            Ordre alphabétique
        </option>
    </select>
    
    <select id="allergene">

        <option value="">
            - Allergènes -
        </option>

        <option value="gluten">
            Gluten
        </option>

        <option value="lait">
            Lait
        </option>

        <option value="oeuf">
            Œuf
        </option>

        <option value="soja">
            Soja
        </option>

        <option value="moutarde">
            Moutarde
        </option>
    </select>
</section>

<!-- Liste des produits -->
<section>
    <h2>Menus Do Brazil</h2>
</section>

<section class="cards menus">

<?php foreach($menus as $menu){
    // Vérification filtres
    if($menu["categorie"] == "Menu Do Brazil" &&(!$search || stripos($menu["name"], $search) !== false )&&( !$categorie || $menu["categorie"] == $categorie)){ ?>
    <!-- Cadre menu -->
    <div class="product-card menu" data-price="<?php echo htmlspecialchars($menu["price"]); ?>" data-name="<?php echo htmlspecialchars($menu["name"])?>">
        <h3><?php echo htmlspecialchars($menu["name"]); ?></h3>
        <p><b><?php echo htmlspecialchars($menu["price"]); ?> €</b></p>
        <p><b>Contenu du menu :</b></p>
        <ul>
        <?php
        // Affichage des plats du menu
        foreach($menu["plats"] as $id){

            foreach($produits as $p){
                if($p["id"] == $id){
                    echo "<li>".$p["name"]."</li>";
                }
            }
        }
        ?>
        </ul>
        <img src="images/<?php echo basename($menu["image"]); ?>" alt="<?php echo htmlspecialchars($menu["name"]); ?>">

        <!-- Formulaire panier -->
        <form method="POST" action="panier.php">
        <input type="hidden"  name="csrf"  value="<?php echo generateCSRF(); ?>">
            <input type="hidden" name="dish" value="<?php echo htmlspecialchars($menu["id"]); ?>>">

            Quantité :
            <input type="number" name="qty" value="1" min="1" max="99">

            <button type="submit">🛒 Ajouter</button>
        </form>
    </div>

<?php } }?>
</section>

<!-- Section des entrées -->
<section>
    <h2>Entrées Do Brazil</h2>
</section>

<section class="cards entrees">

<?php foreach($produits as $produit){
    // Filtrage catégories + recherche
    if($produit["categorie"] == "Entrée Do Brazil" &&(!$search || stripos($produit["name"], $search) !== false )&&( !$categorie || $produit["categorie"] == $categorie)){ ?>
    <div class="product-card entree" data-price="<?php echo htmlspecialchars($produit["price"]); ?>" data-name="<?php echo htmlspecialchars($produit["name"]); ?>"; data-allergenes="<?php echo implode(',', $produit["allergenes"])?>">
        <h3><?php echo htmlspecialchars($produit["name"]); ?></h3>
        <p><b><?php echo htmlspecialchars($produit["price"]); ?> €</b></p>
        <p><?php echo htmlspecialchars($produit["description"]); ?></p>
        <img src="images/<?php echo basename($produit["image"]); ?>" alt="<?php echo htmlspecialchars($produit["name"]); ?>">

        <form method="POST" action="panier.php">
        <input type="hidden"  name="csrf"  value="<?php echo generateCSRF(); ?>">
            <input type="hidden" name="dish" value="<?php echo htmlspecialchars($produit["id"]); ?>">

            Quantité :
            <input type="number" name="qty" value="1" min="1" max="99">

            <button type="submit">🛒 Ajouter</button>
        </form>
    </div>

<?php } }?>
</section>

<!-- Section des plats -->
<section>
    <h2>Plats Do Brazil</h2>
</section>

<section class="cards plats">

<?php foreach($produits as $produit){
    if($produit["categorie"] == "Plat Do Brazil"&&(!$search || stripos($produit["name"], $search) !== false )&&( !$categorie || $produit["categorie"] == $categorie)){ ?>
    <div class="product-card plat" data-price="<?php echo htmlspecialchars($produit["price"]); ?>" data-name="<?php echo htmlspecialchars($produit["name"]); ?>"; data-allergenes="<?php echo implode(',', $produit["allergenes"])?>">
        <h3><?php echo htmlspecialchars($produit["name"]); ?></h3>
        <p><b><?php echo htmlspecialchars($produit["price"]); ?> €</b></p>
        <p><?php echo htmlspecialchars($produit["description"]); ?></p>
        <img src="images/<?php echo basename($produit["image"]); ?>" alt="<?php echo htmlspecialchars($produit["name"]); ?>">

        <form method="POST" action="panier.php">
        <input type="hidden"  name="csrf"  value="<?php echo generateCSRF(); ?>">
            <input type="hidden" name="dish" value="<?php echo htmlspecialchars($produit["id"]); ?>">

            Quantité :
            <input type="number" name="qty" value="1" min="1" max="99">

            <button type="submit">🛒 Ajouter</button>
        </form>
    </div>

<?php } }?>
</section>

<!-- Section des desserts -->
<section>
    <h2>Dessert Do Brazil</h2>
</section>

<section class="cards desserts">

<?php foreach($produits as $produit){
    if($produit["categorie"] == "Dessert Do Brazil"&&(!$search || stripos($produit["name"], $search) !== false )&&( !$categorie || $produit["categorie"] == $categorie)){ ?>
    <div class="product-card dessert" data-price="<?php echo htmlspecialchars($produit["price"]); ?>" data-name="<?php echo htmlspecialchars($produit["name"]); ?>"; data-allergenes="<?php echo implode(',', $produit["allergenes"])?>">
        <h3><?php echo htmlspecialchars($produit["name"]); ?></h3>
        <p><b><?php echo htmlspecialchars($produit["price"]); ?> €</b></p>
        <p><?php echo htmlspecialchars($produit["description"]); ?></p>
        <img src="images/<?php echo basename($produit["image"]); ?>" alt="<?php echo htmlspecialchars($produit["name"]); ?>">

        <form method="POST" action="panier.php">
        <input type="hidden"  name="csrf"  value="<?php echo generateCSRF(); ?>">
            <input type="hidden" name="dish" value="<?php echo htmlspecialchars($produit["id"]); ?>">

            Quantité :
            <input type="number" name="qty" value="1" min="1" max="99">

            <button type="submit">🛒 Ajouter</button>
        </form>
    </div>

<?php } }?>
</section>

<!-- Section des boissons -->
<section>
    <h2>Boissons Do Brazil</h2>
</section>

<section class="cards boissons">

<?php foreach($produits as $produit){
    if($produit["categorie"] == "Boisson Do Brazil"&&(!$search || stripos($produit["name"], $search) !== false )&&( !$categorie || $produit["categorie"] == $categorie)){ ?>
    <div class="product-card boisson" data-price="<?php echo htmlspecialchars($produit["price"]); ?>" data-name="<?php echo htmlspecialchars($produit["name"]); ?>"; data-allergenes="<?php echo implode(',', $produit["allergenes"])?>">
        <h3><?php echo htmlspecialchars($produit["name"]); ?></h3>
        <p><b><?php echo htmlspecialchars($produit["price"]); ?> €</b></p>
        <p><?php echo htmlspecialchars($produit["description"]); ?></p>
        <img src="images/<?php echo basename($produit["image"]); ?>" alt="<?php echo htmlspecialchars($produit["name"]); ?>">

        <form method="POST" action="panier.php">
        <input type="hidden"  name="csrf"  value="<?php echo generateCSRF(); ?>">
            <input type="hidden" name="dish" value="<?php echo htmlspecialchars($produit["id"]); ?>">

            Quantité :
            <input type="number" name="qty" value="1" min="1" max="99">

            <button type="submit">🛒 Ajouter</button>
        </form>
    </div>

<?php } }?>
</section>

<!-- Bas -->
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
<script src="js/tri.js"></script>
</body>
</html>