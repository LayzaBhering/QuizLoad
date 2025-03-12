<?php

$permissao_pagina_index = true;
require_once("App/database.php");
$database = new Database();

// Verificando se o banco de dados tem alguma coisa
if($database->verificar_estado_banco_de_dados() == false){
	$database->criar_estrutura_banco_de_dados();
	$database->listar_todas_atividades();
}
else{
	$database->listar_todas_atividades();
}

$diretorio_atual = parse_url($_SERVER['REQUEST_URI'])["path"];

if($diretorio_atual == "/"){
	require_once("App/home.php");
}
else if($diretorio_atual == "/quiz"){
	require_once("App/quiz.php");
}
else if($diretorio_atual == "/cadastrar-atividade"){
	require_once("App/adicionar quiz.php");
}
else{
	die("nada");
}

?>
