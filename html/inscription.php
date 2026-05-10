<?php session_start();
include("fonctions.php");

if(isset($_POST["login"]) && isset($_POST["password"]) && isset($_POST["name"])){

    $users = readData("json/utilisateurs.json");


    $newUser = [
        "id" => count($users)+1,
        "login" => $_POST["login"],
        "password" => $_POST["password"],
        "role" => "client",
        "name" => $_POST["name"],
        "surname" => $_POST["surname"],
        "phone" => $_POST["phone"],
        "address" => $_POST["address"]
    ];

    $users[] = $newUser;

    saveData("json/utilisateurs.json", $users);

    header("Location: connexion.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription – Copa Cabanane 🍌</title>
    <link id="theme-style" rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/jpg" href="images/favicon.jpg">
</head>
<body>

<!-- HEADER -->
<header class="header">
    <img src="images/logo-copa-cabanane.png" alt="Logo Copa Cabanane">
    <img src="https://static.vecteezy.com/system/resources/previews/031/122/692/non_2x/france-and-brazil-flags-two-flags-vector.jpg" alt="Drapeaux France et Brésil" style="height: 100px; margin-left: 20px; border-radius: 5px; width: 350px;">


    <nav>
        <a href="index.php">Accueil</a>
        <a href="produits.php">Plats</a>
        <a href="inscription.php">Inscription</a>
        <a href="connexion.php">Connexion</a>
    </nav>
</header>

<!-- CONTENU -->
<section>
    <h1>📝 Inscription</h1>
    <p>Créez votre compte pour commander plus rapidement</p>

    <form class="form" method="POST" action="inscription.php" id="formulaire-inscription">
        <label>Nom</label>
        <input type="text" placeholder="Votre nom" name="name" required>

        <label>Prénom</label>
        <input type="text" placeholder="Votre prénom" name="surname" required>

        <label>Email</label>
        <input type="email" placeholder="exemple@mail.com" name="login" id="login" required>
        <p class="error" id="login-error"></p>

        <label>Téléphone</label>
        <input type="tel" placeholder="06 12 34 56 78" name="phone" id="phone" required>
        <p class="error" id="phone-error"></p>

        <label>Adresse</label>
        <input type="text" placeholder="Adresse complète" name="address" required>

        <label>Mot de passe</label>
        <div class="password-container">
            <input type="password" placeholder="Mot de passe" name="password" id="password" maxlength="20" required>
        <button type="button" onclick="togglePassword()">👁️</button>
        </div>
        <p id="password-counter">0/20 caractères</p>
        <p class="error" id="password-error"></p>

        <button type="submit">S'inscrire</button>
        <nav><p style="text-align:center; margin-top:15px;">
            Déja inscrit ?
            <a href="connexion.php">Se connecter</a></nav>
        </p>
    </form>
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

<script src="js/theme.js"></script>
<script src="js/validation.js"></script>
</body>
</html>
