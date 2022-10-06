<?php
$fileJson = file_get_contents(__DIR__ . "/lffsant.json");
$usuarios = (object) [...(array)json_decode($fileJson)];
$input_atividade = new stdClass();
$input_atividade->index += count($usuarios->atividades);
$input_atividade->index = "{$input_atividade->index}";
$input_atividade->atividade = "atividade {$row}";
$input_atividade->date = date("d-m-Y H:i:s");
$input_atividade->status = "open";
array_push($usuarios->atividades, $input_atividade);


// encode array to json
$json = json_encode([
    "nome"=> $usuarios->nome,
    "login"=> $usuarios->login,
    "senha"=> $usuarios->senha,
    "atividades" => $usuarios->atividades
]);
$bytes = file_put_contents(__DIR__  . "/myfile.json", $json); //generate json file
echo "Here is the myfile data $bytes.";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="./backend/crud.php" name="test" method="post">

        <button class="green">Send</button>
    </form>

</body>

</html>