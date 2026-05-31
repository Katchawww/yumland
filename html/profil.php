<?php session_start();
include("fonctions.php");

// Sécurité : si pas connecté -> redirection
if(!isset($_SESSION["user"])){
    header("Location: connexion.php");
    exit;
}
//on récupère les utilisateurs
$users = readData("json/utilisateurs.json");

// Si on clique depuis admin
if(isset($_GET["login"]) && $_SESSION["user"]["role"] == "admin"){
    $login = $_GET["login"];

    //on parcourt les utilisateurs pour trouver celui à afficher
    foreach($users as $u){
        if($u["login"] == $login){
            $user = $u;
            break;
        }
    }

} else {
    // sinon profil normal (utilisateur connecté)
    $user = $_SESSION["user"];
}
//mise à jour via formulaire de modification des données de l'utilisateur
if(isset($_POST["name"])){

    $newUsers = [];
    $utilisateurcourant = $_SESSION["user"]["login"];
    foreach($users as $u){

        if($u["login"] == $utilisateurcourant){
            // modifier les données
            $u["name"] = $_POST["name"];
            $u["surname"] = $_POST["surname"];
            $u["login"] = $_POST["login"];
            $u["phone"] = $_POST["phone"];
            $u["address"] = $_POST["address"];
            
            // mettre à jour session avec nouvelles données
            $_SESSION["user"] = $u; 
        }
        // ajout dans le nouveau tableau d'utilisateurs
        $newUsers[] = $u;
    }

    // validation simple des champs obligatoires
    if(
        empty($_POST["name"]) ||
        empty($_POST["surname"]) ||
        empty($_POST["login"]) ||
        empty($_POST["phone"]) ||
        empty($_POST["address"])
    ){
        echo "error";
        exit;
    }
    
    saveData("json/utilisateurs.json", $newUsers);
    echo "success";
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Profil – Copa Cabanane 🍌</title>
    <link rel="icon" type="image/jpg" href="images/favicon.jpg">
    <link id="theme-style" rel="stylesheet" href="css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

<!-- Haut de page -->
<header class="header">
    <img src="images/logo-copa-cabanane.png" alt="Logo Copa Cabanane">
    <img src="https://static.vecteezy.com/system/resources/previews/031/122/692/non_2x/france-and-brazil-flags-two-flags-vector.jpg" alt="Drapeaux France et Brésil" style="height: 100px; margin-left: 20px; border-radius: 5px; width: 350px;">


    <nav>
        <a href="index.php">Accueil</a>
        <a href="produits.php">Plats</a>
        <a href="panier.php">Panier</a>
        <a href="deconnexion.php">Déconnexion</a>
    </nav>
</header>

<!-- Profil de l'utilisateur-->
<section>
    <h1>👤 Mon profil</h1>
    <p>Bienvenue <?php echo htmlspecialchars($user["name"]); ?> 🍌 </p>

    <div class="card">
        <h2>📋 Informations personnelles</h2>
        <form method="POST" id="form-profil">
        <input type="hidden" name="csrf" value="<?= generateCSRF(); ?>">

    <label><b>Nom :</label></b><br>
    <input type="text" name="name" value="<?php echo htmlspecialchars($user["name"]); ?>"><br><br>

    <label><b>Prénom :</label></b><br>
    <input type="text" name="surname" value="<?php echo htmlspecialchars($user["surname"]); ?>"><br><br>

    <label><b>Email :</label></b><br>
    <input type="text" name="login" value="<?php echo htmlspecialchars($user["login"]); ?>"><br><br>

    <label><b>Téléphone :</label></b><br>
    <input type="text" name="phone" value="<?php echo $user["phone"]; ?>"><br><br>

    <label><b>Adresse :</label></b><br>
    <input type="text" name="address" value="<?php echo $user["address"]; ?>"><br><br>

    <label><b>Rôle :</label></b><br>
    <?php echo $user ["role"]; ?><br><br>

    <label><b>Statut fidélité :</label></b><br>
    <?php echo $user ["statut"]; ?><br><br>

    <button type="submit">💾 Enregistrer</button>
    <p id="profil-success"></p>
</form>
    </div>

    <!-- Commandes -->
    <section>
    <h2>📦 Mes commandes</h2>

    <?php
    $orders = readData("json/commandes.json");

    $found = false;
    // on parcourt les commandes pour trouver celles du client connecté
    foreach($orders as $order){

        if($order["client"] == $user["login"]){

            $found = true;
            echo "<div class='card'>";
            echo "<p>Commande #" . $order["id"] . "</p>";
            echo "<p>Statut : " . $order["status"] . "</p>";

            echo "<ul>";
            foreach($order["items"] as $item){
                echo "<li>Produit ID : ".$item["dish"]." (x".$item["qty"].")</li>";
            }
            echo "</ul>";

            if($order["status"] == "livree"){

                if(!isset($order["note"]) || $order["note"] == null){
                    echo "<nav><a href='avis.php?id=".$order["id"]."'>⭐ Noter la commande</a></nav>";
                } else {
                    echo "<p>Note : ".$order["note"]." ⭐</p>";
                    echo "<p>Avis : ".$order["commentaire"]."</p>";
                }
            }
            if($order["status"] == "payee"){

                echo "<nav><a href='modifier_commande.php?id=".$order["id"]."'>
                ✏️ Modifier commande
                </a></nav>";
            }
            
        }
        echo "</div>";
    }
    if(!$found){
        echo "<p>Aucune commande pour le moment 🍌</p>";
    }
    ?>
</section>

    <!-- Fidélité -->
    <div class="card">
        <h2>⭐ Fidélité</h2>
        <p><b>Statut :</b> <?php echo $user ["statut"]; ?></p>
        <p><b>Remise :</b> <?php echo $user ["remise"]; ?></p>
    </div>
</section>

<!-- bas de page -->
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
<script src="js/profil.js"></script>
</body>
</html>