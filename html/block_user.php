<?php session_start();

include("fonctions.php");
$users = readData("json/utilisateurs.json");
$login = $_POST["login"];
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