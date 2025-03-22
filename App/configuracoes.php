<?php

if(basename($_SERVER['PHP_SELF']) === 'adicionarQuiz.php'){
	exit;
}

class Configuracoes{
    private $instanciaBancoDeDados;

    public function __construct($instanciaBancoDeDados){
        $this->instanciaBancoDeDados = $instanciaBancoDeDados;
        $retornoDB = $this->instanciaBancoDeDados->listarConfiguracoes();
        echo '<script> let configuracoes = { "modo": "'.$retornoDB["Modo_Pergunta_Default"].'", "perguntas": '.$retornoDB["Aleatoriedade_Perguntas_Default"].', "alternativas": '.$retornoDB["Aleatoriedade_Alternativas_Default"].', "duracao": "'.$retornoDB["Tempo_Default"].'" } </script>';

        if(isset($_POST['modo']) != "" && isset($_POST['pergunta']) != "" && isset($_POST['alternativa']) != "" && isset($_POST['duracao']) != ""){
            $modo = $_POST['modo'];
            $pergunta= $_POST['pergunta'];
            $alternativa = $_POST['alternativa'];
            $duracao = $_POST['duracao'];

            $this->instanciaBancoDeDados->atualizarConfiguracoes($modo, $pergunta, $alternativa, $duracao);
            echo '<script>alert("Configurações salvas"); window.location.pathname="/";</script>';
        }
    }
}

$instanciaConfiguracao = new Configuracoes($this->instanciaBancoDeDados);

?>

<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <title>Iniciar Questão</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, inicial-scale=1">
        <link rel="stylesheet" href="Public/configuracoes.css">
        <link rel="stylesheet" href="Public/bootstrap/css/bootstrap.min.css">
        <script defer src="Public/configuracoes.js"></script>
        <script defer src="Public/bootstrap/js/bootstrap.min.js"></script>
    </head>
    <body style="background-color: #353531">

        <!-- Campo do Quiz -->
        <form class="container py-2 mt-5 rounded-4" style="background-color: #BBBAC6" method='POST'>
            <div class="d-flex mt-3 justify-content-center">
                <p class="fs-1">Configurações Padrão</p>
            </div>
            <div class="d-sm-block d-lg-flex justify-content-center mt-4" style="widht: 100%">
                <div class="col-0 col-lg-4 mx-auto mx-lg-0 text-center text-lg-start">
                    <input type='hidden' name='modo' class='elementos-formulario' value=''>
                    <span class="fs-5 clicavel">Seleciona o Modo do Quiz:</span>
                </div>
                <div class="col-0 col-lg-2 mx-auto mx-lg-0 text-center text-lg-start clicavel pergunta-modo">
                    <img class="d-none d-lg-inline imagem-pergunta-modo" src="Public/Icones/nocheck.png" style="width: inherit; height: inherit">
                    <label class="fs-5 clicavel">Normal</label>
                </div>
                <div class="col-0 col-lg-2 mx-auto mx-lg-0 text-center text-lg-start clicavel pergunta-modo">
                    <img class="d-none d-lg-inline imagem-pergunta-modo" src="Public/Icones/nocheck.png" style="width: inherit; height: inherit">
                    <label class="fs-5 clicavel">Explicação</label>
                </div>
            </div>
            <div class="d-sm-block d-lg-flex justify-content-center mt-4" style="widht: 100%">
                <div class="col-0 col-lg-4 mx-auto mx-lg-0 text-center text-lg-start">
                    <input type='hidden' name='pergunta' class='elementos-formulario' value=''>
                    <span class="fs-5 clicavel">Pergunta Aleatórias?</span>
                </div>
                <div class="col-0 col-lg-2 mx-auto mx-lg-0 text-center text-lg-start clicavel pergunta-aleatoria">
                    <img class="d-none d-lg-inline" src="Public/Icones/nocheck.png" style="width: inherit; height: inherit">
                    <span class="fs-5 clicavel" data-valor="1">Sim</span>
                </div>
                <div class="col-0 col-lg-2 mx-auto mx-lg-0 text-center text-lg-start clicavel pergunta-aleatoria">
                    <img class="d-none d-lg-inline" src="Public/Icones/nocheck.png" style="width: inherit; height: inherit">
                    <span class="fs-5 clicavel" data-valor="0">Não</span>
                </div>
            </div>
            <div class="d-sm-block d-lg-flex justify-content-center mt-4" style="widht: 100%">
                <div class="col-0 col-lg-4 mx-auto mx-lg-0 text-center text-lg-start">
                    <input type='hidden' name='alternativa' class='elementos-formulario' value=''>
                    <span class="fs-5 clicavel">Alternativas Aleatórias?</span>
                </div>
                <div class="col-0 col-lg-2 mx-auto mx-lg-0 text-center text-lg-start clicavel alternativa-aleatoria">
                    <img class="d-none d-lg-inline" src="Public/Icones/nocheck.png" style="width: inherit; height: inherit">
                    <span class="fs-5 clicavel" data-valor="1">Sim</span>
                </div>
                <div class="col-0 col-lg-2 mx-auto mx-lg-0 text-center text-lg-start clicavel alternativa-aleatoria">
                    <img class="d-none d-lg-inline" src="Public/Icones/nocheck.png" style="width: inherit; height: inherit">
                    <span class="fs-5 clicavel" data-valor="0">Não</span>
                </div>
            </div>
            <div class="d-sm-block d-lg-flex justify-content-center mt-4" style="widht: 100%">
                <div class="col-0 col-lg-4 mx-auto mx-lg-0 text-center text-lg-start text-center">
                    <span class="fs-5">Duração:</span>
                </div>
                <div class="col-0 col-lg-4 mx-auto mx-lg-0 text-center text-lg-start clicavel">
                    <input type="number" name='duracao' id="duracao" class="border-1 border-dark rounded-4 text-center w-25 elementos-formulario" style="background-color: #BBBAC6"><label class="fs-5 ms-1">Minutos</label>
                </div>
            </div>
            <div class="d-flex my-5 justify-content-center">
                <input type='submit' class="col-8 p-3 rounded-4 d-flex justify-content-center fs-5 text-white border-0" id='botao' style="background-color: #353531" value='Salvar'>
            </div>
        </form>

    </body>
</html>
