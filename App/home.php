<?php

if(basename($_SERVER['PHP_SELF']) === 'home.php'){
	exit;
}

?>

<!DOCTYPE html>
<html lang='pt-br'>
    <head>
        <title>Home</title>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <link rel='stylesheet' href='Public/home.css'>
        <link rel='stylesheet' href='Public/bootstrap/css/bootstrap.min.css'>
        <script defer src='Public/home.js'></script>
        <script defer src='Public/bootstrap/js/bootstrap.min.js'></script>
    </head>
    <body style='background-color: #353531'>


        <!-- Caixa de alerta adicionar atividade --> 
        <div class='container my-5 p-4 border border-5 border-dark rounded-4' id="caixa-popup" style="position: absolute; background-color: #BBBAC6; top:0; left: 50%; transform: translateX(-50%); z-index:1000; display: none">
            <div class="d-flex justify-content-center">
                <div class="col-1">
                    <img class='col-1 pe-2 clicavel' id='botao-fechar-popup-atividade' src='Public/Icones/fechar.svg' style="min-width: 40px; max-width: 70px">
                </div>        
                <h5 class="col-11 ps-4 mb-4" id="elemento-titulo-popup">Adicione o Nome da Atividade</h5>
            </div>
            <form id="formulario-popup-adicionar-atividade" action="cadastrar-atividade" method="POST">
                <div class="d-flex justify-content-between mt-4">
                    <small class="col-2 p-3 fs-5">Nome:</small>
                    <input class="col-9 col-lg-10 p-3 fs-5 border 1 border-dark rounded-4" maxlength="50" id="input-adicionar-atividade" type="text" name="titulo-atividade" style="background-color: E2E2E2">
                </div>
                <input type="submit" class="col-8 d-block mx-auto p-3 mt-5 rounded-5 d-flex justify-content-center fs-5 text-white clicavel" id="botao-adicionar-atividade" value="Enviar" style="border: none; background-color: #353531">
            </form>
        </div>
        
        <!-- Campo de menu -->
        <div class='container d-flex mt-3 px-1'>
            <div class='col-7 rounded-4 d-flex justify-content-around opacity-25' id='opcoes-pergunta-selecionada' style='background-color: #BBBAC6'>
                <img class='p-3 icones clicavel' src='Public/Icones/fechar.svg'>
                <img class='p-3 icones clicavel' src='Public/Icones/iniciar.svg'>
                <img class='p-3 icones clicavel' src='Public/Icones/editar.svg'>
                <img class='p-3 icones clicavel' src='Public/Icones/download.svg'>
            </div>
            <div class='d-flex py-1 px-1 py-md-2 py-xxl-3 col-1 invisible'>
                <small>achou ksksksk</small>
            </div>
            <div class='col-4 ms-auto rounded-4 d-flex justify-content-around' style='background-color: #BBBAC6'>
                <img class='p-3 icones clicavel' src='Public/Icones/adicionar.svg'>
                <img class='p-3 icones clicavel' src='Public/Icones/upload.svg'>
            </div>
        </div>

        <!-- Campo de perguntas -->
        <div class='container d-flex flex-column py-2 my-5 rounded-4' style='background-color: #BBBAC6'>
            <!-- Campo da pergunta -->
<?php
$htmlAtividades="";

if(count($this->instanciaBancoDeDados->atividades) == 0){
    $htmlAtividades.=<<<ATIVIDADE
            <div class='p-1 my-1 d-flex rounded-4 border-2 border-dark campo-pergunta clicavel' data-id='1' style='background-color: #E2E2E2'>
                <!-- Título da pergunta -->
                <div class='col-8 align-self-center px-2 pe-3'>
                    <span class='h3'>Você ainda não tem perguntas, adicione!</span>
                </div>
            </div>
    ATIVIDADE;   
}

else{
    for($contador = 0; $contador < count($this->instanciaBancoDeDados->atividades); $contador++){
        $temporariaTexto = $this->instanciaBancoDeDados->atividades[$contador]["Texto_Atividade"];
        $temporariaQuantidade = $this->instanciaBancoDeDados->atividades[$contador]["Quantidade_Perguntas"];
        $temporariaUltimaTentativa = $this->instanciaBancoDeDados->atividades[$contador]["Ultima_Tentativa"] ?? "-";
        $htmlAtividades.=<<<ATIVIDADE
            <div class='p-1 my-1 d-flex rounded-4 border-2 border-dark campo-pergunta clicavel' data-id='1' style='background-color: #E2E2E2'>
                <!-- Título da pergunta -->
                <div class='col-7 align-self-center px-2 pe-3'>
                    <small class='fs-6'>$temporariaTexto</small>
                </div>
                <!-- Informações sobre a pergunta -->
                <div class='col-5 px-2 align-self-center'>
                    <small class='d-block'>Quantidade: $temporariaQuantidade</small>
                    <small>Última Tentativa: $temporariaUltimaTentativa</small>
                </div>
            </div>
        ATIVIDADE;
    }
}
echo $htmlAtividades;

?>
        </div>
    </body>
</html>
