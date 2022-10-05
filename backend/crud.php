<?php
session_start();
$operation = $_POST["operation"];
$row = $_POST["row"];
// if (!empty($_POST["obj_atividade"])) {

$fileJson = file_get_contents(__DIR__ . "../../jsonFile.json");
$usuarios = (object) [...(array)json_decode($fileJson)];
$usuarios->atividades = (object) [...(array)json_decode($usuarios->atividades)];


if ($operation == "add") {
    $atividade = new stdClass();
    $row += count($usuarios->atividades);
    $atividade->index = "{$row}";
    $atividade->atividade = "atividade {$row}";
    $atividade->date = date("d-m-Y H:i:s");
    $atividade->status = "open";
    array_push($usuarios->atividades, $atividade);

    $newJsonString = json_encode($usuarios);
    file_put_contents(__DIR__ . "../../jsonFile.json", $newJsonString);
    exit;
}

$found_key = array_search($row, array_column($usuarios->atividades, 'index'));

if ($operation == "edit" && $usuarios->atividades[$found_key]) {
    $usuarios->atividades[$found_key]->atividade = "teste";
    $newJsonString = json_encode($usuarios);
    file_put_contents(__DIR__ . "../../jsonFile.json", $newJsonString);
    exit;
}

if ($operation == "delete" && $usuarios->atividades[$found_key]) {
    unset($usuarios->atividades[$found_key]);
    $usuarios->atividades = json_encode(array_values($usuarios->atividades));
    $newJsonString = json_encode($usuarios);


    file_put_contents(__DIR__ . "../../jsonFile.json", $newJsonString);
    exit;
}
