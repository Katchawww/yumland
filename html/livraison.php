<?php session_start(); ?>
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
        <a href="index.php">Déconnexion</a>
    </nav>
</header>

<!-- LIVRAISON -->
<section>
    <h1>🛵 Livraison en cours</h1>
    <p>Informations pour le livreur</p>

    <div class="card">
        <h2>📦 Commande #1019</h2>

        <p><b>Client :</b> Jean Dupont</p>
        <p><b>Adresse :</b> 12 rue du Soleil, Rio De Janeiro</p>
        <p><b>Code interphone :</b> 42B</p>
        <p><b>Étage :</b> 3ᵉ étage</p>
        <p><b>Téléphone :</b> 06 12 34 56 78</p>
        <p><b>Commentaire :</b> Sonner deux fois</p>

        <nav><a href="https://www.google.com/maps" target="_blank" class="btn">
          📍 Ouvrir l’adresse
        </a></nav>

        <br><br>

        <button>✔ Livraison terminée</button>
    </div>
</section>
<br><br>

<!-- FOOTER -->
<footer>
    © 2026 – Copa Cabanane 🍌
</footer>

</body>
</html>
