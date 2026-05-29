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
    if(!isset($_SESSION["user"])) return;
    $users = readData("json/utilisateurs.json");
    foreach($users as $u){
        if($u["login"] === $_SESSION["user"]["login"]){
            if(!empty($u["blocked"])){

                $_SESSION = [];
                session_destroy();

                header("Location: connexion.php");
                exit;
            }
            break;
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