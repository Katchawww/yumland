<?php
session_start();
include("fonctions.php");

$orders = readData("json/commandes.json");

// récupérer ID dès le début
if(isset($_GET["id"])){
    $id = $_GET["id"];
} else {
    echo "ID manquant";
    exit;
}


if(isset($_POST["note"])){

    $newOrders = [];

    foreach($orders as $o){

        if($o["id"] == $id){
            $o["note"] = $_POST["note"];
            $o["commentaire"] = $_POST["commentaire"];
        }

        $newOrders[] = $o;
    }

    file_put_contents("json/commandes.json", json_encode($newOrders, JSON_PRETTY_PRINT));

    header("Location: profil.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Avis – Copa Cabanane 🍌</title>

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
        <a href="profil.php">Profil</a>
        <a href="deconnexion.php">Deconnexion</a>
    </nav>
</header>

<?php if(isset($_GET["id"])){
    $id = $_GET["id"];

    foreach($orders as $o){
        if($o["id"] == $id){
            $order = $o;
            break;
        }
    }
}

// sécurité
if(!isset($order)){
    echo "Commande introuvable";
    exit;
}
?>
<section>
<h2>⭐ Noter la commande #<?php echo $order["id"]; ?></h2>
<p>Laissez une note croustillante de votre commande Copa Cabanane</p>

<form method="POST">
    <select name="note">
        <option value="1">1 ⭐</option>
        <option value="2">2 ⭐</option>
        <option value="3">3 ⭐</option>
        <option value="4">4 ⭐</option>
        <option value="5">5 ⭐</option>
    </select>
    <br><br>

    <label><b>Avis :</b></label>
    <textarea name="commentaire" placeholder="Donnez votre avis..." required></textarea>
    <button type="submit">Envoyer</button>
</form>
</section>
<br><br><br><br><br><br><br><br><br><br>
<br><br><br><br><br>
<br><br><br><br><br>


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

</body>
</html>