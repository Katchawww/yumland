<?php

function readData($file){
    if(!file_exists($file)){
        return [];
    }

    $data = file_get_contents($file);
    return json_decode($data, true) ?? [];
}

function saveData($file, $data){
    file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));
}





function checkBlocked(){

$users =
readData("json/utilisateurs.json");



foreach($users as $u){

    if(
        isset($_SESSION["user"])
        &&
        $u["login"] ==
        $_SESSION["user"]["login"]
    ){

        if(
            isset($u["blocked"])
            &&
            $u["blocked"]
        ){

            session_destroy();

            header("Location: connexion.php");

            exit;
        }
    }
}
}
?>