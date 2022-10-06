<?php
session_start();
$operation = $_POST["operation"];
$input_atividade = (object)$_POST["input_atividade"];
// if (!empty($_POST["obj_atividade"])) {

$fileJson = file_get_contents(__DIR__ . "../../lffsant.json");
$usuarios = (object) [...(array)json_decode($fileJson)];

if (is_string($usuarios->atividades)){

    $usuarios->atividades = (array) [...(array)json_decode($usuarios->atividades)];
}



if ($operation == "add") {

    $input_atividade->index += count($usuarios->atividades);
    $input_atividade->index = "{$input_atividade->index}";
    $input_atividade->atividade = "atividade {$row}";
    $input_atividade->date = date("d-m-Y H:i:s");
    $input_atividade->status = "open";
    array_push($usuarios->atividades, $input_atividade);

    $newJsonString = json_encode($usuarios);
    file_put_contents(__DIR__ . "../../lffsant.json", $newJsonString);
    exit;
}

$found_key = array_search($input_atividade->index, array_column($usuarios->atividades, 'index'));

if ($operation == "edit" && $usuarios->atividades[$found_key]) {
    $usuarios->atividades[$found_key] = $input_atividade;
    $newJsonString = json_encode($usuarios);
    file_put_contents(__DIR__ . "../../lffsant.json", $newJsonString);
    exit;
}

if ($operation == "delete" && $usuarios->atividades[$found_key]) {
    unset($usuarios->atividades[$found_key]);
    $usuarios->atividades = json_encode(array_values($usuarios->atividades));
    $newJsonString = json_encode($usuarios);

    file_put_contents(__DIR__ . "../../lffsant.json", $newJsonString);
    exit;
}
