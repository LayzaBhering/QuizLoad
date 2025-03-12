<?php

// Verifica se quem chamou o .php foi a página index
if(!isset($permissao_pagina_index)){
	exit;
}

// Verificando se é uma nova atividade ou adição a uma existente
if(isset($_POST["pergunta"])){
    $numero_questao = $_POST["numeracao-questao"]+1;

    $titulo_atividade = htmlspecialchars(substr($_POST["titulo-atividade"], 0, 100));

    $pergunta = htmlspecialchars(substr($_POST["pergunta"], 0, 250));

    $alternativas = [
        $_POST["alternativa-1"],
        $_POST["alternativa-2"],
        $_POST["alternativa-3"],
        $_POST["alternativa-4"],
        $_POST["alternativa-5"],
        $_POST["alternativa-6"],
        $_POST["alternativa-7"],
        $_POST["alternativa-8"],
        $_POST["alternativa-9"],
        $_POST["alternativa-10"]
    ];

    $alternativas = array_filter($alternativas, function($alternativa_atual){
        if($alternativa_atual != ""){
            return htmlspecialchars(substr($alternativa_atual, 0,200));
        }
    });

    $corretas = str_split(substr($_POST["alternativas-correta"], 0, 10));

    $corretas = array_map(function($correta){
        return htmlspecialchars($correta);
    }, $corretas);

    $explicacao = htmlspecialchars(substr($_POST["explicacao"], 0, 400));

    $database->adicionar_nova_pergunta($titulo_atividade, $pergunta, $alternativas, $corretas, $explicacao);

    // Verificando se é adição de uma nova pergunta ou finalizado a atual
    if(isset($_POST["opcao"]) && $_POST["opcao"] == "finalizar"){
        header("Location: /");
        exit();
    }
}
else if(isset($_POST["titulo-atividade"])){
    // Verificando se pergunta já existe
    if($database -> verifica_se_pergunta_ja_existe(htmlspecialchars(substr($_POST["titulo-atividade"], 0, 100)))){
        echo '<script>alert("Essa pergunta já existe")</script>';
        echo '<script>window.location.href = window.location.href.replace("cadastrar-atividade", "")</script>';
        exit;
    }

    // Vai executar caso não exista
    $numero_questao = 1;
    $retorno_db = $database -> adicionar_nova_atividade(htmlspecialchars(substr($_POST["titulo-atividade"], 0, 100)));
}
else{
    die("Crie uma atividade");
}

?>

<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<title>teste</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, inicial-scale=1">
    <link rel="stylesheet" href="Public/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="Public/adicionar quiz.css">
		<script defer src="Public/adicionar quiz.js"></script>
	</head>
  <body style="background-color: #353531">

 		<!-- Campo do Quiz -->
    <form method="POST" class="container d-block py-2 my-5 rounded-4" id="formulario" style="background-color: #BBBAC6">
        <div class="d-flex px-1 mt-3 justify-content-center">
            <input type="text" name="titulo-atividade" class="d-none" value="<?php echo htmlspecialchars($_POST["titulo-atividade"]); ?>">
            <p class="fs-1 px-xxl-5 text-center">Adicione as perguntas e alternatias do: <?php echo htmlspecialchars($_POST["titulo-atividade"]); ?></p>
        </div>
        <p class="fs-1 px-xxl-5 text-center">(Questão <?php echo $numero_questao; ?>)</p>
        <input type="text" name="numeracao-questao" class="d-none" value="<?php echo $numero_questao; ?>">
        <p class="fs-5 px-1 text-center">Marque o checkbox para colocar a alternativa como correta (para remover a alternativa, basta deixar vazio)</p>
        <div class="col-12 col-sm-10 mx-auto p-4 my-4 rounded" id="elemento-pergunta" style="background-color: #E2E2E2">
            <p class="fs-4 p-2 text-break clicavel" id="elemento-pergunta-texto">Adicione a pergunta aqui (clique aqui)</p>
            <input type="text" name="pergunta" maxlength="250" id="elemento-pergunta-input" class="fs-4 d-none border-1 border-dark rounded-4 p-2 w-100">

            <!-- Alternativas 1 e 2 -->
            <div class="d-block d-lg-flex justify-content-between mt-2 mt-lg-4 w-100">
                <div class="col-12 col-lg-5 text-start clicavel">
                    <div class="h-75 d-flex align-items-center elemento-alternativas-completo">
                        <img class="d-none mx-2 elemento-alternativas-check" width="30px" height="auto" src="Public/Icones/nocheck.png">
                        <input type="text" name="alternativa-1" maxlength="200" class="d-none border-1 border-dark rounded-4 mx-2 p-3 h-50 w-75 elemento-alternativas-input">
                        <p class="d-block m-0 fs-5 elemento-alternativas-texto p-3 w-100 text-break">Adicione Alternativa 1</p>
                    </div>
                </div>
                <div class="col-12 col-lg-5 text-start clicavel mt-2 mt-lg-0">
                    <div class="h-75 d-flex align-items-center elemento-alternativas-completo">
                        <img class="d-none mx-2 elemento-alternativas-check" width="30px" height="auto" src="Public/Icones/nocheck.png">
                        <input type="text" name="alternativa-2" maxlength="200" class="d-none border-1 border-dark rounded-4 mx-2 p-3 h-50 w-75 elemento-alternativas-input">
                        <p class="d-block m-0 fs-5 elemento-alternativas-texto p-3 w-100 text-break">Adicione Alternativa 2</p>
                    </div>
                </div>
            </div>

            <!-- Alternativas 3 e 4 -->
            <div class="d-block d-lg-flex justify-content-between mt-2 mt-lg-4 w-100">
                <div class="col-12 col-lg-5 text-start clicavel">
                    <div class="h-75 d-flex align-items-center elemento-alternativas-completo">
                        <img class="d-none mx-2 elemento-alternativas-check" width="30px" height="auto" src="Public/Icones/nocheck.png">
                        <input type="text" name="alternativa-3" maxlength="200" class="d-none border-1 border-dark rounded-4 mx-2 p-3 h-50 w-75 elemento-alternativas-input">
                        <p class="d-block m-0 fs-5 elemento-alternativas-texto p-3 w-100 text-break">Adicione Alternativa 3</p>
                    </div>
                </div>
                <div class="col-12 col-lg-5 text-start clicavel mt-2 mt-lg-0">
                    <div class="h-75 d-flex align-items-center elemento-alternativas-completo">
                        <img class="d-none mx-2 elemento-alternativas-check" width="30px" height="auto" src="Public/Icones/nocheck.png">
                        <input type="text" name="alternativa-4" maxlength="200" class="d-none border-1 border-dark rounded-4 mx-2 p-3 h-50 w-75 elemento-alternativas-input">
                        <p class="d-block m-0 fs-5 elemento-alternativas-texto p-3 w-100 text-break">Adicione Alternativa 4</p>
                    </div>
                </div>
            </div>


            <!-- Alternativas 5 e 6 -->
            <div class="d-block d-lg-flex justify-content-between mt-2 mt-lg-4 w-100">
                <div class="col-12 col-lg-5 text-start clicavel">
                    <div class="h-75 d-flex align-items-center elemento-alternativas-completo">
                        <img class="d-none mx-2 elemento-alternativas-check" width="30px" height="auto" src="Public/Icones/nocheck.png">
                        <input type="text" name="alternativa-5" maxlength="200" class="d-none border-1 border-dark rounded-4 mx-2 p-3 h-50 w-75 elemento-alternativas-input">
                        <p class="d-block m-0 fs-5 elemento-alternativas-texto p-3 w-100 text-break">Adicione Alternativa 5</p>
                    </div>
                </div>
                <div class="col-12 col-lg-5 text-start clicavel mt-2 mt-lg-0">
                    <div class="h-75 d-flex align-items-center elemento-alternativas-completo">
                        <img class="d-none mx-2 elemento-alternativas-check" width="30px" height="auto" src="Public/Icones/nocheck.png">
                        <input type="text" name="alternativa-6" maxlength="200" class="d-none border-1 border-dark rounded-4 mx-2 p-3 h-50 w-75 elemento-alternativas-input">
                        <p class="d-block m-0 fs-5 elemento-alternativas-texto p-3 w-100 text-break">Adicione Alternativa 6</p>
                    </div>
                </div>
            </div>


            <!-- Alternativas 7 e 8 -->
            <div class="d-block d-lg-flex justify-content-between mt-2 mt-lg-4 w-100">
                <div class="col-12 col-lg-5 text-start clicavel">
                    <div class="h-75 d-flex align-items-center elemento-alternativas-completo">
                        <img class="d-none mx-2 elemento-alternativas-check" width="30px" height="auto" src="Public/Icones/nocheck.png">
                        <input type="text" name="alternativa-7" maxlength="200" class="d-none border-1 border-dark rounded-4 mx-2 p-3 h-50 w-75 elemento-alternativas-input">
                        <p class="d-block m-0 fs-5 elemento-alternativas-texto p-3 w-100 text-break">Adicione Alternativa 7</p>
                    </div>
                </div>
                <div class="col-12 col-lg-5 text-start clicavel mt-2 mt-lg-0">
                    <div class="h-75 d-flex align-items-center elemento-alternativas-completo">
                        <img class="d-none mx-2 elemento-alternativas-check" width="30px" height="auto" src="Public/Icones/nocheck.png">
                        <input type="text" name="alternativa-8" maxlength="200" class="d-none border-1 border-dark rounded-4 mx-2 p-3 h-50 w-75 elemento-alternativas-input">
                        <p class="d-block m-0 fs-5 elemento-alternativas-texto p-3 w-100 text-break">Adicione Alternativa 8</p>
                    </div>
                </div>
            </div>


            <!-- Alternativas 9 e 10 -->
            <div class="d-block d-lg-flex justify-content-between mt-2 mt-lg-4 w-100">
                <div class="col-12 col-lg-5 text-start clicavel">
                    <div class="h-75 d-flex align-items-center elemento-alternativas-completo">
                        <img class="d-none mx-2 elemento-alternativas-check" width="30px" height="auto" src="Public/Icones/nocheck.png">
                        <input type="text" name="alternativa-9" maxlength="200" class="d-none border-1 border-dark rounded-4 mx-2 p-3 h-50 w-75 elemento-alternativas-input">
                        <p class="d-block m-0 fs-5 elemento-alternativas-texto p-3 w-100 text-break">Adicione Alternativa 9</p>
                    </div>
                </div>
                <div class="col-12 col-lg-5 text-start clicavel mt-2 mt-lg-0">
                    <div class="h-75 d-flex align-items-center elemento-alternativas-completo">
                        <img class="d-none mx-2 elemento-alternativas-check" width="30px" height="auto" src="Public/Icones/nocheck.png">
                        <input type="text" name="alternativa-10" maxlength="200" class="d-none border-1 border-dark rounded-4 mx-2 p-3 h-50 w-75 elemento-alternativas-input">
                        <p class="d-block m-0 fs-5 elemento-alternativas-texto p-3 w-100 text-break">Adicione Alternativa 10</p>
                    </div>
                </div>
            </div>

            <!-- Lugar para colocar a explicação -->
            <div class="d-block mt-2 w-100">
                    <p class="d-block m-0 fs-5 text-center p-3 w-100 text-break">Coloque a explicação, caso não queira, deixe em branco.</p>
                </div>
                <div class="d-block col-12 mt-2">
                    <textarea class="d-block mx-auto border-1 border-dark w-75 p-3 rounded-4" form="formulario" name="explicacao" maxlength="400" style="resize: none"></textarea>
                </div>
            </div>


            <!-- Botões -->
            <div class="d-block d-lg-flex my-5 justify-content-center">
                <input type="hidden" name="alternativas-correta" id="elemento-alternativas-corretas">
                <input type="hidden" name="opcao" id="elemento-botao-selecionado">
                <input type="submit" name="outra" class="col-5 py-3 my-3 mx-auto mx-lg-3 rounded-4 border-0 d-flex justify-content-center text-white" style="background-color: #353531" value="Adicionar Outra Pergunta">
                <input type="submit" name="finalizar" class="col-5 py-3 my-3 mx-auto mx-lg-3 rounded-4 border-0 d-flex justify-content-center text-white" style="background-color: #353531" value="Finalizar">
            </div>
        </div>
    </form>
	</body>
</html>
