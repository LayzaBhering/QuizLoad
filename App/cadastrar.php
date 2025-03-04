<?php

if(!isset($_POST["titulo-atividade"])){
	die("Por favor, volte para a página home e insira o título");
}

echo($_POST["titulo-atividade"]);

?>
