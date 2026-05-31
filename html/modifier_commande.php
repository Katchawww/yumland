<?php
session_start();
include("fonctions.php");
// vérifier si utilisateur bloqué
checkBlocked();

// sécurité : si pas connecté -> redirection
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
$menus = readData("json/menus.json");


// récupérer commande
foreach($orders as $o){

    if($o["id"] == $id){
        $order = $o;
        break;
    }
}


// sécurité si commande existe ou pas
if(!isset($order)){
    exit("Commande introuvable");
}


// sécurité acces seulement pour le client propriétaire de la commande
if(
    $order["client"] != $_SESSION["user"]["login"]
){
    exit("Accès interdit");
}


// commande modifiable seulement si payée
if(!isset($order) || $order["status"] != "payee"){
    exit("Commande non modifiable");
}


// modifier quantités
if(isset($_POST["update"])){
    $newItems = [];
$nouveauTotal = 0;

// liste des ids produits valides pour sécurité
$validIds = array_merge( array_column($produits, "id"), array_column($menus, "id") );
// on reconstruit la liste des items de la commande à partir des quantités envoyées
foreach($_POST["qty"] as $dishId => $qty){

    // on vérifie que le plat existe
    if(!in_array($dishId, $validIds)){
        continue;
    }

    $qty = intval($qty);
    // on vérifie que la quantité est valide
    if($qty < 0 || $qty > 99){
        continue;
    }

    if($qty > 0){
        $newItems[] = [
            "dish" => intval($dishId),
            "qty" => $qty
        ];

        $found = false;

        foreach($produits as $p){
            if($p["id"] == $dishId){
                $nouveauTotal += $p["price"] * $qty;
                $found = true;
                break;
            }
        }
        if(!$found){
            foreach($menus as $m){
                if($m["id"] == $dishId){
                    $nouveauTotal += $m["price"] * $qty;
                    break;
                }
            }
        }
    }
}

$remise = $_SESSION["user"]["remise"] ?? "aucun";
if($remise == "5%"){
    $nouveauTotal *= 0.95;
}
elseif($remise == "10%"){
    $nouveauTotal *= 0.90;
}

    // comparer ancien / nouveau total
    $ancienTotal = $order["total"];

    // mise a jour de la commande
    foreach($orders as &$o){
        if($o["id"] == $id){
            $o["items"] = $newItems;
            $o["total"] = $nouveauTotal;
        }
    }

    saveData("json/commandes.json", $orders);

    if($nouveauTotal > $ancienTotal){
        // calculer la différence et rediriger vers paiement modification
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

<!-- haut de page -->
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

<!-- message confirmation pour le client après modification -->
<?php
if(isset($message)){
    echo "<p><b>".htmlspecialchars($message)."</b></p>";
}
?>

<!-- formulaire de modification de la commande -->
<form method="POST">
<input type="hidden" name="csrf" value="<?php echo generateCSRF(); ?>">
<!-- liste des produits avec les quantités de la commande -->
<?php
foreach(array_merge($produits, $menus) as $p){
        $qty = 0;

    // vérifier si le produit existe déjà dans la commande
    foreach($order["items"] as $item){
        if($item["dish"] == $p["id"]){
            $qty = $item["qty"];
        }
    }
?>
<div class="card">
    <h3><?php echo $p["name"]; ?></h3>
    <p><?php echo $p["price"]; ?> €</p>
    <img src="images/<?php echo $p["image"]; ?>" width="150">
    <br><br>

    Quantité :
    <input type="number" name="qty[<?php echo $p["id"]; ?>]" value="<?php echo $qty; ?>" min="0" max="99">
</div>
<br>
<?php }?>

<button type="submit" name="update">
    💾 Mettre à jour la commande
</button>
</form>
</section>

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

</body>
</html>