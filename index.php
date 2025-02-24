<?php

$diretorio_atual = parse_url($_SERVER['REQUEST_URI'])["path"];
$diretorio_atual = explode("/", $diretorio_atual);

if($diretorio_atual[1] == ""){
	require_once("Public/home.html");
}
else if($diretorio_atual[1] == "quiz"){
	require_once("Public/quiz.html");
}
else{
	echo "<p> Outra página não home</p>";
}

?>
