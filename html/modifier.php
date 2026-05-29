<?php
session_start();
include("fonctions.php");
// vérifie si l'utilisateur est bloqué
checkBlocked();

// sécurité vérifie si connecté
if(!isset($_SESSION["user"])){
    header("Location: connexion.php");
    exit;
}
// on veux modifier un utilisateur, donc sécurité vérifie si admin
if(!isset($_SESSION["user"]) || $_SESSION["user"]["role"] != "admin"){
    exit("Accès refusé");
}

// on récupère les utilisateurs
$users = readData("json/utilisateurs.json");

// récupérer utilisateur à modifier via login
if(isset($_GET["login"])){
    $login = $_GET["login"];

    //on parcourt les utilisateurs pour trouver celui à modifier
    foreach($users as $user){
        if($user["login"] == $login){
            $user = $user;
            break;
        }
    }
}

// si formulaire envoyé
if(isset($_POST["name"])){
    $newUsers = [];
    foreach($users as $user){
        // si c'est l'utilisateur à modifier
        if($user["login"] == $_GET["login"]){
            // modifier les données
            $user["name"] = $_POST["name"];
            $user["surname"] = $_POST["surname"];
            $user["login"] = $_POST["login"];
            $user["role"] = $_POST["role"];
            $user["statut"] = $_POST["statut"];
            // la remise ne peut être modifiée que si le statut est VIP ou Rei de la jungle
            $user["remise"] = $user["remise"];
        }

        $newUsers[] = $user;
    }

    // sauvegarde
    saveData("json/utilisateurs.json", $newUsers);
    header("Location: admin.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Copa Cabanane 🍌</title>
    <link id="theme-style" rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/jpg" href="images/favicon.jpg">
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
</head>

<header class="header">
    <img src="images/logo-copa-cabanane.png" alt="Logo Copa Cabanane">
    <img src="https://static.vecteezy.com/system/resources/previews/031/122/692/non_2x/france-and-brazil-flags-two-flags-vector.jpg" 
    alt="Drapeaux France et Brésil" style="height: 100px; margin-left: 20px; border-radius: 5px; width: 350px;">
    <nav>
        <a href="index.php" title="aller à l'accueil">Accueil</a>
        <a href="produits.php" title="aller aux plats">Plats</a>
        <a href="inscription.php" title="pour s'inscrire">Inscription</a>
        <a href="connexion.php" title="pour se connecter">Connexion</a>
    </nav>
</header>
<section>
<h2>✏️ Modifier utilisateur</h2>

<!-- formulaire de modification des données de l'utilisateur-->
<form method="POST">
<input type="hidden" name="csrf" value="<?= generateCSRF(); ?>">

    <label><b>Nom :</b></label><br>
    <input type="text" name="name" value="<?php echo $user["name"]; ?>"><br><br>

    <label><b>Prénom :</b></label><br>
    <input type="text" name="surname" value="<?php echo $user["surname"]; ?>"><br><br>

    <label><b>Email :</b></label><br>
    <input type="text" name="login" value="<?php echo $user["login"]; ?>"><br><br>

    <label><b>Rôle :</b></label><br>
    <select name="role">
        <option <?php if($user["role"]=="client") echo "selected"; ?>>client</option>
        <option <?php if($user["role"]=="admin") echo "selected"; ?>>admin</option>
    </select><br><br>

    <label><b>Statut :</b></label><br>
    <select name="statut">
         <option <?php if($user["statut"]=="aucun") echo "selected"; ?>>aucun</option>
         <option <?php if($user["statut"]=="VIP") echo "selected"; ?>>VIP</option>
         <option <?php if($user["statut"]=="Rei de la jungle") echo "selected"; ?>>Rei de la jungle</option>
    </select><br><br>

    <label><b>Remise :</b></label><br>
    <select name="remise">
         <option <?php if($user["remise"]=="aucun") echo "selected"; ?>>aucun</option>
         <option <?php if($user["remise"]=="5%") echo "selected"; ?>>5%</option>
         <option <?php if($user["remise"]=="10%") echo "selected"; ?>>10%</option>
    </select><br><br>
    <button type="submit">💾 Enregistrer</button>

</form>
</section>
<script src="js/theme.js"></script>
</body>

<footer>
    <p>© 2026 – Copa Cabanane 🍌 | Soleil dans l’assiette </p>
    <nav>
    <p>Contact :
    <a href="mailto:contactcopacabanane@gmail.com">📧 contactcopacabanane@gmail.com</a>
    | <a href="https://www.instagram.com"> Instagram</a>
     | <a href="https://www.tiktok.com/fr/">Tiktok</a></p> 
    </nav>  
</footer>

</html>