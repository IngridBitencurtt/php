<?php
session_start();

$banco_dados_mock = array(
	"login" => "lffsant",
	"senha" => "12345",
	"nome"  => "Luís Felipe"
);

if ($_POST["operation"] == 'load') {

	if (isset($_SESSION["login"])) {
		$_SESSION["nome"] = $banco_dados_mock["nome"];
		$_SESSION["login"] = $banco_dados_mock["login"];

		$json = json_encode([
			"nome" => $_SESSION["nome"],
			"login" => $_SESSION["login"],
			"status" => "logado"
		]);
		echo $json;
	} else {
		echo '{ "nome" : "undefined" }';
	}
} else if ($_POST["operation"] == 'login') {
	if (!(isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW']))) {
		echo '{ "status" : "nao_logado" }';
		header('HTTP/1.0 401 Unauthorized');
	} else {
		$login = $_SERVER['PHP_AUTH_USER'];
		$senha = $_SERVER['PHP_AUTH_PW'];

		if (
			$login == $banco_dados_mock["login"] &&
			$senha == $banco_dados_mock["senha"]
		) {
			$_SESSION["nome"] = $banco_dados_mock["nome"];
			$_SESSION["login"] = $banco_dados_mock["login"];

			//D:\Projects\php\ingrid\php\backend\session_manager_auth.php
			$fileJson = file_get_contents(__DIR__ . "../../lffsant.json");

			$usuarios = (object) [...(array)json_decode($fileJson)];

			// if (is_string($usuarios->atividades)) {

			// 	$usuarios->atividades = (array) [...(array)json_decode($usuarios->atividades)];
			// }

			$json = json_encode([
				"usuarios" => $usuarios,
				"nome" => $_SESSION["nome"],
				"login" => $_SESSION["login"],
				"status" => "logado"
			]);

			echo $json;
		} else {
			echo '{ "status" : "nao_logado" }';
			header('HTTP/1.0 401 Unauthorized');
		}
	}
} else if ($_POST["operation"] == 'logout') {

	session_destroy();


	echo '{ "nome" : "undefined" }';
} else {

	echo '{ "invalid_operation" : "' . $_POST["operation"] . '" }';
}
