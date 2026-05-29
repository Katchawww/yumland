<?php session_start();

include("fonctions.php");
// charger utilisateurs
$users = readData("json/utilisateurs.json");
// sécurité vérifie si admin
if($_SESSION["user"]["role"] != "admin"){
    exit("Accès refusé");
}
// sécurité vérifie si login existe
if(!isset($_POST["login"])){
    exit("Erreur");
}
// nettoyage du login
$login = trim($_POST["login"]);
$newUsers = [];
$status = "";

// parcourir les utilisateurs pour trouver celui à bloquer/débloquer
foreach($users as $u){
    if($u["login"] == $login){
        // inverser le statut de blocage
        $u["blocked"] = !$u["blocked"];
        // définir le statut à afficher
        $status = $u["blocked"]  ? "blocked" : "unblocked";
    }

    $newUsers[] = $u;
}

saveData( "json/utilisateurs.json", $newUsers);
echo $status;