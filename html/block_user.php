<?php session_start();

include("fonctions.php");
$users = readData("json/utilisateurs.json");
if($_SESSION["user"]["role"] != "admin"){
    exit("Accès refusé");
}
if(!isset($_POST["login"])){
    exit("Erreur");
}
$login = trim($_POST["login"]);
$newUsers = [];
$status = "";

foreach($users as $u){
    if($u["login"] == $login){
        $u["blocked"] = !$u["blocked"];
        $status = $u["blocked"]  ? "blocked" : "unblocked";
    }

    $newUsers[] = $u;
}

saveData( "json/utilisateurs.json", $newUsers);
echo $status;