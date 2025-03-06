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
		$sql = "CREATE TABLE Atividades (ID_Atividade INTEGER PRIMARY KEY AUTO_INCREMENT, Texto_Atividade VARCHAR (50), Quantidade_Perguntas INTEGER, Ultima_Tentativa VARCHAR (10));";
		$this->conexao_banco_de_dados->query($sql);
		$sql = "CREATE TABLE Perguntas (ID_Pergunta INTEGER PRIMARY KEY AUTO_INCREMENT, ID_Atividade_Correspondente INTEGER, Texto_Pergunta VARCHAR (50));";
		$this->conexao_banco_de_dados->query($sql);
		$sql = "CREATE TABLE Alternativas (ID_Alternativa INTEGER PRIMARY KEY AUTO_INCREMENT, ID_Pergunta_Correspondente INTEGER, Texto_Alternativa VARCHAR (50), Correta BOOL);";
		$this->conexao_banco_de_dados->query($sql);
		$sql = "CREATE TABLE Configuracoes (Tempo_Default INTEGER, Aleatoriedade_Perguntas_Default BOOL, Aleatoriedade_Alternativas_Default BOOL);";
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

	public function adicionar_nova_atividade($nome_atividade){
		$consulta_tratada = $this->conexao_banco_de_dados->prepare("INSERT INTO Atividades (Texto_Atividade, Quantidade_Perguntas, Ultima_Tentativa) VALUES (?, 0, '')");

		// Verificando se ocorreu erro
		if($consulta_tratada == false){
			die("Erro ao criar a consulta tratada");
		}

		$consulta_tratada->bind_param("s", $nome_atividade);
		$resultado = $consulta_tratada->execute();

		$consulta_tratada->close();

		return $nome_atividade;

	}

	public function adicionar_nova_pergunta($titulo_atividade, $pergunta, $alternativas, $corretas){
		// Consultando o ID da Atividade
		$consulta_tratada = $this->conexao_banco_de_dados->prepare("SELECT ID_Atividade, Quantidade_Perguntas FROM Atividades WHERE Texto_Atividade=?");

		if($consulta_tratada === false){
			die("Erro ao criar a conexão para enviar a atividade");
		}

		$consulta_tratada->bind_param("s", $titulo_atividade);
		$consulta_tratada->execute();
		$consulta_tratada->store_result();

		if($consulta_tratada->num_rows == 0){
			die("Não foi possível encontrar a atividade");
		}

		$consulta_tratada->bind_result($id_atividade, $quantidade_perguntas);
		$consulta_tratada->fetch();
		$consulta_tratada->close();

		// Adicionando Pergunta da Atividade
		$insercao_tratada = $this->conexao_banco_de_dados->prepare("INSERT INTO Perguntas (ID_Atividade_Correspondente, Texto_Pergunta) VALUES (?, ?)");
		
		if($insercao_tratada === false){
			die("Erro ao criar a conexão para enviar a pergunta");
		}

		$insercao_tratada->bind_param("is", $id_atividade, $pergunta);
		$resultado = $insercao_tratada->execute();

		if($resultado == false){
			die("Erro ao Cadastrar Pergunta");
		}

		$id_pergunta = $insercao_tratada->insert_id;

		$insercao_tratada->close();

		// Adicionando Alternativas da Atividade
		$contador_alternativa = 0;
		for($contador = 0; $contador < count($alternativas); $contador++){
			$insercao_tratada = $this->conexao_banco_de_dados->prepare("INSERT INTO Alternativas (ID_Pergunta_Correspondente, Texto_Alternativa, Correta) VALUES (?, ?, ?)");
		
			if($insercao_tratada === false){
				die("Erro ao criar a conexão para enviar as alternativas $contador");
			}

			if($contador == $corretas[$contador_alternativa]){
				$alternativa_atual_correta = 1;
				if(isset($corretas[$contador_alternativa+1])){
					$contador_alternativa++;
				}
			}
			else{
				$alternativa_atual_correta = 0;
			}

			$insercao_tratada->bind_param("isi", $id_pergunta, $alternativas[$contador], $alternativa_atual_correta);
			$resultado = $insercao_tratada->execute();

			if($resultado == false){
				die("Erro ao Cadastrar Pergunta");
			}
		}

		// Atualizando a quantidade de perguntas
		$quantidade_perguntas++;
		$sql = "UPDATE Atividades SET Quantidade_Perguntas=$quantidade_perguntas WHERE ID_Atividade=$id_atividade";
		$retorno = $this->conexao_banco_de_dados->query($sql);

		if($retorno == false){
			die("Erro ao atualizar a quantidade");
		}
	}
}
