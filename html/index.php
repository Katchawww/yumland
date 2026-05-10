<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Copa Cabanane 🍌</title>
    <link id="theme-style" rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/jpg" href="images/favicon.jpg">
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
</head>


<body>

<header class="header">
    <img src="images/logo-copa-cabanane.png" alt="Logo Copa Cabanane">
    <img src="https://static.vecteezy.com/system/resources/previews/031/122/692/non_2x/france-and-brazil-flags-two-flags-vector.jpg" 
    alt="Drapeaux France et Brésil" style="height: 100px; margin-left: 20px; border-radius: 5px; width: 350px;">
    <nav>
        <a href="index.php" title="aller à l'accueil">Accueil</a>
        <a href="produits.php" title="aller aux plats">Plats</a>
        <?php if(isset($_SESSION["user"])): ?>
            <!-- UTILISATEUR CONNECTÉ -->
            <?php if($_SESSION["user"]["role"] == "livreur"): ?>
                <a href="livraison.php">Livraisons</a>
            <?php endif; ?>
            <?php if($_SESSION["user"]["role"] == "admin"): ?>
                <a href="admin.php">Admin</a>
            <?php endif; ?>
            <?php if($_SESSION["user"]["role"] == "restaurateur"): ?>
                <a href="restauration.php">Restauration</a>
            <?php endif; ?>
            <?php if($_SESSION["user"]["role"] == "client"): ?>
                <a href="profil.php">Profil</a>
                <a href="panier.php">Panier</a>
            <?php endif; ?>
            <a href="deconnexion.php">Déconnexion</a>
        <?php else: ?>
            <!-- UTILISATEUR NON CONNECTÉ -->
            <a href="connexion.php">Connexion</a>
            <a href="inscription.php">Inscription</a>
        <?php endif; ?>
    </nav>
</header>

<div class="infos">
    📍 Paris | 🕒 11h–23h | 📞 01 23 45 67 89   | <button onclick="toggleTheme()"> ☀️/🌙</button>
    <?php if(isset($_SESSION["user"])): ?>
    <p>Bienvenue <?php echo $_SESSION["user"]["name"]; ?> 🍌</p>
    <?php endif; ?>
</div>


<section class="hero">
    <h1>Bem-Vindo à Copa Cabanane</h1>
    <p>Le restaurant tropical qui met la banane 🍌</p>

    <form method="GET" action="produits.php">
        <input type="text" name="search" placeholder="Rechercher un plat...">
    </form>
</section>



<section>
    <h2>🔥 Plats populaires</h2>
<nav>
    <div class="cards">
        <div class="card">
            <h3><a href="produits.php#burger">🍌 Burger Cabanane</a></h3>
            <p>Banane rôtie, steak, sauce maison</p>
        </div>

        <div class="card">
            <h3><a href="produits.php#poulet">🌴 Frango tropical</a></h3>
            <p>Mariné aux épices exotiques</p>
        </div>

        <div class="card">
            <h3><a href="produits.php#smoothie">🍹 Smoothie banana</a></h3>
            <p>Frais et 100% naturel</p>
        </div>
    </div>
</nav>
</section>




<section class="concept">
    <h2>Notre concept</h2>
    <p>
        De la favela à la plage, les meilleurs dans la restauration brésilienne débarquent à Paris pour vous faire voyager.<br>
        Copa Cabanane vous transporte sous les tropiques avec une cuisine
        fraîche, colorée et conviviale comme à la maison, c'est digne d'un duel de nourriture dans les favelas. Sortez les fourchettes et degustez !<br>
        Sur place, à emporter ou en livraison, entre amis, en familles ou solo, venez vous évader au brésil pendant ce doux repas.
    </p>
</section>

<section>
    <h2>💬 Avis clients</h2>

    <div class="cards">
        <div class="card">⭐️⭐️⭐️⭐️⭐️<br>“Super ambiance !”</div>
        <div class="card">⭐️⭐️⭐️⭐️⭐️<br>“J'ai kiffé de Malade”</div>
        <div class="card">⭐️⭐️⭐️⭐️⭐️<br>“Livraison rapide 🔥”</div>
    </div>
</section>



<footer>
    <p>© 2026 – Copa Cabanane 🍌 | Soleil dans l’assiette </p>
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
