<?php
session_start();
include("fonctions.php");

// sécurité si pas connecté -> redirection
if(!isset($_SESSION["user"])){
    header("Location: connexion.php");
    exit;
}

$users = readData("json/utilisateurs.json");

// vérifie si un login est passé en paramètre pour identifier l'utilisateur à supprimer
if(isset($_GET["login"])){
    $login = $_GET["login"];
    // créer un nouveau tableau d'utilisateurs sans celui à supprimer
    $newUsers = [];
    foreach($users as $u){
        if($u["login"] != $login){
            $newUsers[] = $u;
        }
    }

    // sauvegarde apres suppression
    saveData("json/utilisateurs.json", $newUsers);

}

// retour admin 
header("Location: admin.php");
exit;
?>