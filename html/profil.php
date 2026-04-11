<?php session_start();
include("fonctions.php");

// Sécurité : si pas connecté → redirection
if(!isset($_SESSION["user"])){
    header("Location: connexion.php");
    exit;
}
$users = readData("json/utilisateurs.json");

// Si on clique depuis admin
if(isset($_GET["login"])){

    $login = $_GET["login"];

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
            
            $_SESSION["user"] = $u; // mettre à jour session avec nouvelles données
        }

        $newUsers[] = $u;
    }

    // sauvegarde
    saveData("json/utilisateurs.json", $newUsers);
    header("Location: profil.php");
    exit;
}
?>

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
        <a href="panier.php">Panier</a>
        <a href="deconnexion.php">Déconnexion</a>
    </nav>
</header>

<!-- PROFIL -->
<section>
    <h1>👤 Mon profil</h1>
    <p>Bienvenue <?php echo $user ["name"]; ?> 🍌 </p>

    <!-- INFOS UTILISATEUR -->
    <div class="card">
        <h2>📋 Informations personnelles</h2>
        <form method="POST">

    <label><b>Nom :</label></b><br>
    <input type="text" name="name" value="<?php echo $user["name"]; ?>"><br><br>

    <label><b>Prénom :</label></b><br>
    <input type="text" name="surname" value="<?php echo $user["surname"]; ?>"><br><br>

    <label><b>Email :</label></b><br>
    <input type="text" name="login" value="<?php echo $user["login"]; ?>"><br><br>

    <label><b>Téléphone :</label></b><br>
    <input type="text" name="phone" value="<?php echo $user["phone"]; ?>"><br><br>

    <label><b>Adresse :</label></b><br>
    <input type="text" name="address" value="<?php echo $user["address"]; ?>"><br><br>

    <label><b>Rôle :</label></b><br>
    <?php echo $user ["role"]; ?><br><br>

    <label><b>Statut fidélité :</label></b><br>
    <?php echo $user ["statut"]; ?><br><br>

    <button type="submit">💾 Enregistrer</button>
</form>
    </div>

    <!-- COMMANDES -->
    <section>
    <h2>📦 Mes commandes</h2>

    <?php
    $orders = readData("json/commandes.json");

    $found = false;

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
            
        }
        echo "</div>";
    }
    if(!$found){
        echo "<p>Aucune commande pour le moment 🍌</p>";
    }
    ?>
</section>

    <!-- FIDÉLITÉ -->
    <div class="card">
        <h2>⭐ Fidélité</h2>
        <p><b>Statut :</b> <?php echo $user ["statut"]; ?></p>
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
