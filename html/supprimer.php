<?php
session_start();
include("fonctions.php");

// sécurité
if(!isset($_SESSION["user"])){
    header("Location: connexion.php");
    exit;
}

$users = readData("json/utilisateurs.json");

if(isset($_GET["login"])){

    $login = $_GET["login"];
    $newUsers = [];

    foreach($users as $u){
        if($u["login"] != $login){
            $newUsers[] = $u;
        }
    }

    // sauvegarde
    file_put_contents("json/utilisateurs.json", json_encode($newUsers, JSON_PRETTY_PRINT));

}

// retour admin
header("Location: admin.php");
exit;
?>
