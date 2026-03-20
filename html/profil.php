<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Profil – Copa Cabanane 🍌</title>

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
        <a href="produits.php">Plats</a>
        <a href="profil.php">Profil</a>
        <a href="index.php">Déconnexion</a>
    </nav>
</header>

<!-- PROFIL -->
<section>
    <h1>👤 Mon profil</h1>
    <p>Bienvenue sur votre espace personnel</p>

    <!-- INFOS UTILISATEUR -->
    <div class="card">
        <h2>📋 Informations personnelles</h2>
        <p><b>Nom :</b> Escobar ✏️</p>
        <p><b>Prénom :</b> Pablo ✏️</p>
        <p><b>Email :</b> pablo.escobar@mail.com ✏️</p>
        <p><b>Téléphone :</b> 06 12 34 56 78 ✏️</p>
        <p><b>Adresse :</b> 12 rue du Soleil, Rio De Janeiro ✏️</p>
    </div>

    <!-- COMMANDES -->
    <div class="card">
        <h2>🧾 Mes commandes</h2>
        <ul>
            <li>🍌 Burger Cabanane – 12 € (Livrée)</li>
            <li>🌴 Poulet tropical – 14 € (Livrée)</li>
            <li>🍹 Smoothie banane – 6 € (Livrée)</li>
        </ul>
    </div>

    <!-- FIDÉLITÉ -->
    <div class="card">
        <h2>⭐ Fidélité</h2>
        <p>Points cumulés : <b>120</b></p>
        <p>🎁 Un dessert offert à 150 points</p>
    </div>
</section>

<!-- FOOTER -->
<footer>
    © 2026 – Copa Cabanane 🍌
    <p>Contact us:
        <a href="https://mail.google.com/mail/u/0/?hl=fr#inbox?compose=new">📧 contactcopacabanane@gmail.com</a>
        | <a href="https://www.instagram.com"> Instagram</a>
         | <a href="https://www.tiktok.com/fr/">Tiktok</a></p> 
</footer>

</body>
</html>
