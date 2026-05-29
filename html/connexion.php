<?php
session_start();
include("fonctions.php");

// on vérifie si le formulaire a été soumis
if(isset($_POST["login"]) && isset($_POST["password"])){
// on charge les données des utilisateurs et des livreurs
$users = readData("json/utilisateurs.json");
$livreurs = readData("json/livreurs.json");

// on vérifie la connexion pour les livreurs
foreach($livreurs as $l){
    if($l["login"] == $_POST["login"] &&
       $l["password"] == $_POST["password"]){
        
        // si les identifiants sont corrects, on régénère la session de livreur
        $_SESSION["user"] = $l;
        // redirection vers la page de livraison
        header("Location: ../livraison.php");
        exit;
    }
}

// on vérifie la connexion pour les utilisateurs
foreach($users as $user){

 if($user["login"] == $_POST["login"] &&
    $user["password"] == $_POST["password"]){
        
    // on securise la session en régénérant l'ID de session
    session_regenerate_id(true);

    // on stocke les données de l'utilisateur dans la session
    $_SESSION["user"] = $user;
    // si admin -> admin.php, si restaurateur -> restauration.php, sinon profil.php
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

// si on arrive ici, c'est que les identifiants sont incorrects
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

<!-- Haut de page -->
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

<section>
    <h1>🔐 Connexion</h1>
    <p>Connectez-vous à votre compte Copa Cabanane</p>
    <br><br>
    <!-- Formulaire de connexion -->
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
