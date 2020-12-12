<?php
function toArray($obj){
    return [$obj->getLastName(),$obj->getFirstName(),$obj->getBirth(),$obj->getAddress(),$obj->getJob()];
}

function saveData($data){
    $dataJson= json_encode($data);
    file_put_contents("data.json", $dataJson);
}

function load()
{
    $data = file_get_contents("data.json");
    return json_decode($data);
}