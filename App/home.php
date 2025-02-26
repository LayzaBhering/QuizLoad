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


        <!-- Caixa de alerta --> 
        <div class='alert alert-warning alert-dismissible' style='display: none; position: absolute; top: 0; right: 0; width: 15%'>
            teste
            <button class='btn-close' data-bs-dismiss='alert'></button>
        </div>
        
        <!-- Campo de menu -->
        <div class='container d-flex mt-3 px-1'>
            <div class='col-7 rounded-4 d-flex justify-content-around opacity-25' id='opcoes-pergunta-selecionada' style='background-color: #BBBAC6'>
                <img class='p-3 icones clicavel' src='Public/Icones/fechar.svg'></img>
                <img class='p-3 icones clicavel' src='Public/Icones/iniciar.svg'></img>
                <img class='p-3 icones clicavel' src='Public/Icones/editar.svg'></img>
                <img class='p-3 icones clicavel' src='Public/Icones/download.svg'></img>
            </div>
            <div class='d-flex py-1 px-1 py-md-2 py-xxl-3 col-1 invisible'>
                <small>achou ksksksk</small>
            </div>
            <div class='col-4 ms-auto rounded-4 d-flex justify-content-around' style='background-color: #BBBAC6'>
                <img class='p-3 icones clicavel' src='Public/Icones/adicionar.svg'></img>
                <img class='p-3 icones clicavel' src='Public/Icones/upload.svg'></img>
            </div>
        </div>

        <!-- Campo de perguntas -->
        <div class='container d-flex flex-column py-2 mt-5 rounded-4' style='background-color: #BBBAC6'>
            <!-- Campo da pergunta -->
<?php
$teste = "teste";
$html_atividades="";

if(count($database->atividades) == 0){
    $html_atividades.=<<<ATIVIDADE
            <div class='p-1 my-1 d-flex rounded-4 border-2 border-dark campo-pergunta clicavel' data-id='1' style='background-color: #E2E2E2'>
                <!-- Título da pergunta -->
                <div class='col-8 align-self-center px-2 pe-3'>
                    <span class='h3'>Você ainda não tem perguntas, adicione!</span>
                </div>
            </div>
    ATIVIDADE;   
}

else{
    for($contador = 0; $contador < count($database->atividades); $contador++){
        $temporaria_texto = $database->atividades[$contador]["Texto_Atividade"];
        $temporaria_quantidade = $database->atividades[$contador]["Quantidade_Perguntas"];
        $temporaria_ultima_tentativa = date("d/m/Y", strtotime($database->atividades[$contador]["Ultima_Tentativa"]));
        $html_atividades.=<<<ATIVIDADE
            <div class='p-1 my-1 d-flex rounded-4 border-2 border-dark campo-pergunta clicavel' data-id='1' style='background-color: #E2E2E2'>
                <!-- Título da pergunta -->
                <div class='col-7 align-self-center px-2 pe-3'>
                    <small class='fs-6'>$temporaria_texto</small>
                </div>
                <!-- Informações sobre a pergunta -->
                <div class='col-5 px-2 align-self-center'>
                    <small class='d-block'>Quantidade: $temporaria_quantidade</small>
                    <small>Última Tentativa: $temporaria_ultima_tentativa</small>
                </div>
            </div>
        ATIVIDADE;
    }
}
echo $html_atividades;

?>
        </div>
    </body>
</html>
