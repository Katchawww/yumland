<?php
session_start();

include("fonctions.php");

checkBlocked();

// sécurité
if(!isset($_SESSION["user"])){
    header("Location: connexion.php");
    exit;
}


// récupérer id commande
if(!isset($_GET["id"])){
    exit("Commande introuvable");
}
$id = intval($_GET["id"]);


// charger données
$orders = readData("json/commandes.json");
$produits = readData("json/plats.json");


// récupérer commande
foreach($orders as $o){

    if($o["id"] == $id){
        $order = $o;
        break;
    }
}


// sécurité
if(!isset($order)){
    exit("Commande introuvable");
}


// sécurité utilisateur
if(
    $order["client"] != $_SESSION["user"]["login"]
){
    exit("Accès interdit");
}


// commande modifiable seulement si payée
if($order["status"] != "payee"){
    exit("Commande non modifiable");
}


// modifier quantités
if(isset($_POST["update"])){
    $nouveauTotal = 0;

    foreach($order["items"] as &$item){
        $dishId = $item["dish"];

        if(isset($_POST["qty"][$dishId])){
            $item["qty"] = intval($_POST["qty"][$dishId]);
        }

        foreach($produits as $p){
            if($p["id"] == $dishId){
                $nouveauTotal += $p["price"] * $item["qty"];
            }
        }
    }


    // comparer ancien / nouveau total
    $ancienTotal = $order["total"];

    foreach($orders as &$o){

        if($o["id"] == $id){
            $o["items"] = $order["items"];
            $o["total"] = $nouveauTotal;
        }
    }

    saveData("json/commandes.json", $orders);

    // message
    if($nouveauTotal > $ancienTotal){

        $difference = $nouveauTotal - $ancienTotal;
        $message ="⚠️ Vous devez payer ". number_format($difference, 2). " € supplémentaires";
        $_SESSION["difference"] = $difference;
        header("Location: paiement_modification.php?id=".$id);
        exit;
    }

    else if($nouveauTotal < $ancienTotal){
        $message ="✅ Commande modifiée (aucun remboursement)";
    }

    else {
        $message ="✅ Commande mise à jour";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier commande 🍌</title>
    <link id="theme-style" rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/jpg" href="images/favicon.jpg">
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
</head>
<body>

<header class="header">
    <img src="images/logo-copa-cabanane.png" alt="Logo Copa Cabanane">
    <img src="https://static.vecteezy.com/system/resources/previews/031/122/692/non_2x/france-and-brazil-flags-two-flags-vector.jpg" alt="Drapeaux France et Brésil" style="height: 100px; margin-left: 20px; border-radius: 5px; width: 350px;">

    <nav>
        <a href="profil.php">Profil</a>
        <a href="produits.php">Produits</a>
        <a href="deconnexion.php">Déconnexion</a>
    </nav>

</header>



<section>

<h1>✏️ Modifier commande</h1>



<?php
if(isset($message)){
    echo "<p><b>".$message."</b></p>";
}
?>

<form method="POST">
<?php
foreach($order["items"] as $item){
    foreach($produits as $p){
        if($p["id"] == $item["dish"]){
?>

<div class="card">
    <h3><?php echo $p["name"]; ?></h3>
    <p><?php echo $p["price"]; ?> €</p>
    <img src="images/<?php echo $p["image"]; ?>" width="150">
    <br><br>

    Quantité :
    <input type="number" name="qty[<?php echo $p["id"]; ?>]" value="<?php echo $item["qty"]; ?>" min="0" max="99">
</div>

<br>

<?php
        }
    }
}
?>

<button type="submit" name="update">
    💾 Mettre à jour la commande
</button>

</form>

</section>



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

</body>
</html>