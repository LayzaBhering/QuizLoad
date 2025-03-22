<?php

if(basename($_SERVER['PHP_SELF']) === 'database.php'){
	exit;
}

class DataBase{
	private $conexaoBancoDeDados;
	public $atividades = [];

	public function __construct(){
		$senhaBancoDeDados = getenv('DB_PASSWORD');
		$nomeBancoDeDados = getenv('DB_NAME');
		$this->conexaoBancoDeDados = new mysqli('mysql', 'root', $senhaBancoDeDados, $nomeBancoDeDados);
		if($this->conexaoBancoDeDados->connect_error){
			echo "Erro ao  conectar ao banco de dados";
			exit;
		}
	}

	public function verificarSeBancoDeDadosJaFoiCriado(){
		$sql = "SELECT * FROM Atividades";
		$retorno = $this->conexaoBancoDeDados->query($sql);

		if($retorno == false){
			if($this->conexaoBancoDeDados->error == "Table 'QuizLoad.Atividades' doesn't exist"){
				return false;
			}
			else{
				die("Erro ao conectar ao DB");
			}
		}
		else{
			return true;
		}
	}
		
	public function criarEstruturaBancoDeDados(){
		$sql = "CREATE TABLE Atividades (ID_Atividade INTEGER PRIMARY KEY AUTO_INCREMENT, Texto_Atividade VARCHAR (100), Quantidade_Perguntas INTEGER, Ultima_Tentativa VARCHAR (10));";
		$this->conexaoBancoDeDados->query($sql);
		$sql = "CREATE TABLE Perguntas (ID_Pergunta INTEGER PRIMARY KEY AUTO_INCREMENT, ID_Atividade_Correspondente INTEGER, Texto_Pergunta VARCHAR (250), Explicacao_Pergunta VARCHAR(400));";
		$this->conexaoBancoDeDados->query($sql);
		$sql = "CREATE TABLE Alternativas (ID_Alternativa INTEGER PRIMARY KEY AUTO_INCREMENT, ID_Pergunta_Correspondente INTEGER, Texto_Alternativa VARCHAR (200), Correta BOOL);";
		$this->conexaoBancoDeDados->query($sql);
		$sql = "CREATE TABLE Configuracoes (Modo_Pergunta_Default ENUM('Normal', 'Explicacao'), Aleatoriedade_Perguntas_Default BOOL, Aleatoriedade_Alternativas_Default BOOL, Tempo_Default INTEGER);";
		$this->conexaoBancoDeDados->query($sql);
		$sql = "INSERT INTO Configuracoes (Modo_Pergunta_Default, Aleatoriedade_Perguntas_Default, Aleatoriedade_Alternativas_Default, Tempo_Default) VALUE ('Normal', True, True, 30)";
		$this->conexaoBancoDeDados->query($sql);
	}

	public function listarConfiguracoes(){
		$sql = 'SELECT * FROM Configuracoes';
		$retorno = $this->conexaoBancoDeDados->query($sql);

		if($retorno == false && $retorno -> num_rows){
			die('Erro ao consultar as configuraçẽos');
		}

		return $retorno->fetch_assoc();
	}

	public function atualizarConfiguracoes($modo, $pergunta, $alternativa, $duracao){
		$sql = 'UPDATE Configuracoes SET Modo_Pergunta_Default = "'.$modo.'", Aleatoriedade_Perguntas_Default = "'.$pergunta.'", Aleatoriedade_Alternativas_Default = "'.$alternativa.'", Tempo_Default = '.$duracao.';';

		$retorno = $this->conexaoBancoDeDados->query($sql);

		if($retorno == false){
			die('Erro ao atualizar as informações de configuração');
		}

	}

	public function listarTodasAtividades(){
		$sql = "SELECT * FROM Atividades";
		$retorno = $this->conexaoBancoDeDados->query($sql);

		if($retorno->num_rows > 0){
			$contador=0;
			while($row = $retorno->fetch_assoc()){
				$this->atividades[$contador] = $row;
				$contador+=1;
			}
		}
	}

	public function adicionarNovaAtividade($nomeAtividade){
		$consultaTratada = $this->conexaoBancoDeDados->prepare("INSERT INTO Atividades (Texto_Atividade, Quantidade_Perguntas, Ultima_Tentativa) VALUES (?, 0, '')");

		// Verificando se ocorreu erro
		if($consultaTratada == false){
			die("Erro ao criar a consulta tratada");
		}

		$consultaTratada->bind_param("s", $nomeAtividade);
		$resultado = $consultaTratada->execute();

		$consultaTratada->close();
	}

	public function verificaSePerguntaJaExiste($tituloAtividade){
		$consultaTratada = $this->conexaoBancoDeDados->prepare("SELECT ID_Atividade FROM Atividades WHERE Texto_Atividade=?");

		if($consultaTratada === false){
			die("Erro ao criar a conexão para verificar se atividade já exite");
		}

		$consultaTratada->bind_param("s", $tituloAtividade);
		$consultaTratada->execute();
		$consultaTratada->store_result();

		if($consultaTratada->num_rows == 0){
			return false;
		}
		else{
			return true;
		}
	}

	public function adicionarNovaPergunta($tituloAtividade, $pergunta, $alternativas, $alternativasCorretas, $explicacao){
		// Consultando o ID da Atividade
		$consultaTratada = $this->conexaoBancoDeDados->prepare("SELECT ID_Atividade, Quantidade_Perguntas FROM Atividades WHERE Texto_Atividade=?");

		if($consultaTratada === false){
			die("Erro ao criar a conexão para enviar a atividade");
		}

		$consultaTratada->bind_param("s", $tituloAtividade);
		$consultaTratada->execute();
		$consultaTratada->store_result();

		if($consultaTratada->num_rows == 0){
			die("Não foi possível encontrar a atividade");
		}

		$consultaTratada->bind_result($idAtividade, $quantidadePerguntas);
		$consultaTratada->fetch();
		$consultaTratada->close();

		// Adicionando Pergunta da Atividade
		$insercaoTratada = $this->conexaoBancoDeDados->prepare("INSERT INTO Perguntas (ID_Atividade_Correspondente, Texto_Pergunta, Explicacao_Pergunta) VALUES (?, ?, ?)");
		
		if($insercaoTratada === false){
			die("Erro ao criar a conexão para enviar a pergunta");
		}

		$insercaoTratada->bind_param("iss", $idAtividade, $pergunta, $explicacao);
		$resultado = $insercaoTratada->execute();

		if($resultado == false){
			die("Erro ao Cadastrar Pergunta");
		}

		$idPergunta = $insercaoTratada->insert_id;

		$insercaoTratada->close();

		// Adicionando Alternativas da Atividade
		$contadorAlternativa = 0;
		for($contador = 0; $contador < count($alternativas); $contador++){
			$insercaoTratada = $this->conexaoBancoDeDados->prepare("INSERT INTO Alternativas (ID_Pergunta_Correspondente, Texto_Alternativa, Correta) VALUES (?, ?, ?)");
		
			if($insercaoTratada === false){
				die("Erro ao criar a conexão para enviar as alternativas $contador");
			}

			if($contador == $alternativasCorretas[$contadorAlternativa]){
				$alternativaCorretaAtual = 1;
				if(isset($alternativasCorretas[$contadorAlternativa+1])){
					$contadorAlternativa++;
				}
			}
			else{
				$alternativaCorretaAtual = 0;
			}

			$insercaoTratada->bind_param("isi", $idPergunta, $alternativas[$contador], $alternativaCorretaAtual);
			$resultado = $insercaoTratada->execute();

			if($resultado == false){
				die("Erro ao Cadastrar Pergunta");
			}
		}

		// Atualizando a quantidade de perguntas
		$quantidadePerguntas++;
		$sql = "UPDATE Atividades SET Quantidade_Perguntas=$quantidadePerguntas WHERE ID_Atividade=$idAtividade";
		$retorno = $this->conexaoBancoDeDados->query($sql);

		if($retorno == false){
			die("Erro ao atualizar a quantidade");
		}
	}
}
