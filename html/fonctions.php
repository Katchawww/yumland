<?php

function readData($file){
    if(!file_exists($file)){
        return [];
    }

    $data = file_get_contents($file);
    return json_decode($data, true) ?? [];
}

function saveData($file, $data){
    file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT), LOCK_EX);
}


function checkBlocked(){

$users = readData("json/utilisateurs.json");
foreach($users as $u){

    if(
        isset($_SESSION["user"]) && isset($u["login"]) && $u["login"] == $_SESSION["user"]["login"]
    ){

        if(
            isset($u["blocked"]) && $u["blocked"]
        ){
            $_SESSION = [];
            session_destroy();
            header("Location: connexion.php");
            exit;
        }
    }
}
}

function generateCSRF(){

if(empty($_SESSION['csrf'])){
    $_SESSION['csrf'] = bin2hex(random_bytes(32));
}

return $_SESSION['csrf'];
}
?>