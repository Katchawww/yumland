<?php
session_start();
include("fonctions.php");


if(isset($_POST["login"]) && isset($_POST["password"])){
$users = readData("json/utilisateurs.json");
$livreurs = readData("json/livreurs.json");

foreach($livreurs as $l){
    if($l["login"] == $_POST["login"] &&
       $l["password"] == $_POST["password"]){

        $_SESSION["user"] = $l;
        header("Location: ../livraison.php");
        exit;
    }
}

foreach($users as $user){

 if($user["login"] == $_POST["login"] &&
    $user["password"] == $_POST["password"]){
    session_regenerate_id(true);

    $_SESSION["user"] = $user;
    if($user["role"] == "admin"){
        header("Location: ../admin.php");
        exit;
    } 
    else if($user["role"] == "restaurateur"){
        header("Location: ../restauration.php");
        exit;
    }
    else {
        header("Location: ../profil.php");
        exit;
 }
}
}

$error = "Login incorrect";
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion – Copa Cabanane 🍌</title>

    <link rel="icon" type="image/jpg" href="images/favicon.jpg">
    <link id="theme-style" rel="stylesheet" href="css/style.css">
</head>
<body>

<!-- HEADER -->
<header class="header">
    <img src="images/logo-copa-cabanane.png" alt="Logo Copa Cabanane">
    <img src="https://static.vecteezy.com/system/resources/previews/031/122/692/non_2x/france-and-brazil-flags-two-flags-vector.jpg" alt="Drapeaux France et Brésil" style="height: 100px; margin-left: 20px; border-radius: 5px; width: 350px;">


    <nav>
        <a href="index.php">Accueil</a>
        <a href="produits.php">Menu</a>
        <a href="inscription.php">Inscription</a>
        <a href="connexion.php">Connexion</a>
    </nav>
</header>

<!-- CONTENU -->
<section>
    <h1>🔐 Connexion</h1>
    <p>Connectez-vous à votre compte Copa Cabanane</p>
    <br><br>
    <form class="form" method="POST" action="connexion.php">
    <input type="hidden" name="csrf" value="<?php echo generateCSRF(); ?>">
        <label>Email</label>
        <input type="email" name="login" required placeholder="exemple@mail.com">

        <label>Mot de passe</label>
        <input type="password" name="password" required placeholder="••••••••">

        <button type="submit">Se connecter</button>

        <nav><p style="text-align:center; margin-top:15px;">
            Pas encore de compte ?
        <a href="inscription.php">S’inscrire</a></nav>
        </p>
        <p style="color: red; text-align: center; margin-top: 15px;">
        <?php if(isset($error)) echo $error; ?>
    </p>
    </form>
</section>
<br><br><br><br><br>

<!-- FOOTER -->
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
