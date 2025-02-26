<?php

if(!isset($permissao_pagina_index)){
	exit;
}

class DataBase{
	private $conexao_banco_de_dados;
	private $estado_banco_de_dados;

	public $atividades=[];

	public function __construct(){
		$this->conexao_banco_de_dados = new mysqli("mysql", "root", "password", "QuizLoad");
		if($this->conexao_banco_de_dados->connect_error){
			echo "Erro ao  conectar ao banco de dados";
			exit;
		}
	}

	public function verificar_estado_banco_de_dados(){
		$sql = "SELECT * FROM Atividades";
		$retorno = $this->conexao_banco_de_dados->query($sql);

		if($retorno == false){
			if($this->conexao_banco_de_dados->error == "Table 'QuizLoad.Atividades' doesn't exist"){
				$this->estado_banco_de_dados = false;
				return false;
			}
			else{
				die("Erro ao conectar ao DB");
			}
		}
		else{
			$this->estado_banco_de_dados = true;
			return true;
		}
	}
		
	public function criar_estrutura_banco_de_dados(){
		$sql = "CREATE TABLE Atividades (ID_Atividade INTEGER PRIMARY KEY AUTO_INCREMENT, Texto_Atividade VARCHAR (50), Quantidade_Perguntas INTEGER, Ultima_Tentativa DATE);";
		$this->conexao_banco_de_dados->query($sql);
		$sql = "CREATE TABLE Perguntas (ID_Pergunta INTEGER PRIMARY KEY AUTO_INCREMENT, ID_Atividade_Correspondente INTEGER, Texto_Pergunta VARCHAR (50));";
		$this->conexao_banco_de_dados->query($sql);
		$sql = "CREATE TABLE Alternativas (ID_Alternativa INTEGER PRIMARY KEY AUTO_INCREMENT, ID_Pergunta_Correspondente INTEGER, Texto_Alternativa VARCHAR (50));";
		$this->conexao_banco_de_dados->query($sql);
	}

	public function listar_todas_atividades(){
		$sql = "SELECT * FROM Atividades";
		$retorno = $this->conexao_banco_de_dados->query($sql);

		if($retorno->num_rows == 0){
		}
		else{
			$contador=0;
			while($row = $retorno->fetch_assoc()){
				$this->atividades[$contador] = $row;
				$contador+=1;
			}
		}
	}

}
