<?php

class Index{
	private $instanciaBancoDeDados;

	public function __construct(){
		
		if(!file_exists('App/database.php')){
			throw new Exception ('Arquivo database não encontrado');
		}

		require_once('App/database.php');
		$this->instanciaBancoDeDados = new Database();
		
		if(!$this->instanciaBancoDeDados->verificarSeBancoDeDadosJaFoiCriado()){
			$this->instanciaBancoDeDados->criarEstruturaBancoDeDados();
		}
		$this->instanciaBancoDeDados->listarTodasAtividades();
	}

	public function verificarRota(){

		$diretorioAtual = parse_url($_SERVER['REQUEST_URI'])["path"];

		if($diretorioAtual == "/"){
			require_once("App/home.php");
		}
		else if($diretorioAtual == "/quiz"){
			require_once("App/quiz.php");
		}
		else if($diretorioAtual == "/cadastrar-atividade"){
			require_once("App/adicionarAtividade.php");
		}
		else if($diretorioAtual == "/configuracoes"){
			require_once("App/configuracoes.php");
		}
		else{
			die("nada");
		}
	}
}

$instanciaIndex = new Index();
$instanciaIndex->verificarRota();

?>