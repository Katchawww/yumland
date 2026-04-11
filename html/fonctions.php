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
?>
