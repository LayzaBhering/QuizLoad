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
$diretorio_atual = explode("/", $diretorio_atual);

if($diretorio_atual[1] == ""){
	require_once("App/home.php");
}
else if($diretorio_atual[1] == "quiz"){
	require_once("Public/quiz.html");
}
else{
	require_once("Public/adicionar quiz.html");
}

?>
