// Variáveis
let icones = document.getElementsByClassName("icones");
let campo_pergunta = document.getElementsByClassName("campo-pergunta");
let opcoes_elemento_selecionado = document.getElementById("opcoes-pergunta-selecionada");

let formulario_pop_up_adicionar_atividade = document.getElementById("formulario-popup-adicionar-atividade");
let input_pop_up_adicionar_atividade = document.getElementById("input-adicionar-atividade");

let pop_up = false;
let elemento_caixa_popup = document.getElementById("caixa-popup");
let botao_fechar_caixa_popup = document.getElementById("botao-fechar-caixa-popup-atividade");

// Funções
let elemento_campo_pergunta_selecionado = false;
let funcao_selecionar_campo_pergunta = function(elemento_atual){
	
	// Verificando se tem pergunta
	if(campo_pergunta = "\n            \n            \n                "){
		console.error("Sem perguntas");
		return;
	}

	elemento_atual.classList.add("border");
	
	if(elemento_campo_pergunta_selecionado == false){
		elemento_campo_pergunta_selecionado = elemento_atual;
		opcoes_elemento_selecionado.classList.remove("opacity-25");
	}
	else if(elemento_campo_pergunta_selecionado != elemento_atual){
		elemento_campo_pergunta_selecionado.classList.remove("border");
		elemento_campo_pergunta_selecionado = elemento_atual;
		opcoes_elemento_selecionado.classList.remove("opacity-25");
	}
}

let funcao_mostrar_ocultar_popup_adicionar_atividade = function(){
	if(pop_up == false){
		elemento_caixa_popup.style.display = "block";
		pop_up = true;
	}
	else{
		elemento_caixa_popup.style.display = "none";
		pop_up = false;
	}
}

// Adicionando evento aos elementos

// Adicionando evento nos ícones
icones[0].addEventListener("click", ()=>{
	// Verificando se o popup está aberto
	if(pop_up == true){
		console.error("Pop Up aberto");
		return;
	}
	// Verificando se tem pergunta selecionada
	else if(elemento_campo_pergunta_selecionado != false){
		elemento_campo_pergunta_selecionado.classList.remove("border");
		opcoes_elemento_selecionado.classList.add("opacity-25");
		elemento_campo_pergunta_selecionado = false;
	}
});

// Ícones no menu
icones[1].addEventListener("click", ()=>{
	// Irei implementar
});

icones[2].addEventListener("click", ()=>{
	// Irei implementar
});

icones[3].addEventListener("click", ()=>{
	// Irei implementar
});

icones[4].addEventListener("click", ()=>{
	// Verificando te sem popup aberto
	if(pop_up == true){
		console.error("Pop Up aberto");
		return;
	}
	funcao_mostrar_ocultar_popup_adicionar_atividade();
});

icones[5].addEventListener("click", ()=>{
	// Irei implementar
});

// Adicionando evento nos campo de perguntas
let contador_interno=0
for(var contador=0; contador < campo_pergunta.length; contador++){
	campo_pergunta[contador].addEventListener("click", function(){
		funcao_selecionar_campo_pergunta(this);
	});
}

// Adicionando evento no botão de enviar do pop-up (adicionar atividade)
formulario_pop_up_adicionar_atividade.onsubmit = function(evento){
	if(pop_up == false){
		console.error("Não é possível enviar, porque o pop-up de adicionar atividade não está aberto");
		return;
	}
	evento.preventDefault();
	if(input_pop_up_adicionar_atividade.value == ""){
		alert("Favor, inserir o nome antes de enviar");
		return;
	}
	formulario_pop_up_adicionar_atividade.submit();
}

// Adicionando evento no botão de fechar do pop-up (adicionar atividade)
botao_fechar_caixa_popup.onclick = function(){
	if(pop_up == false){
		console.error("Não é possível fechar, porque o pop-up já está fechado");
		return;
	}
	else{
		funcao_mostrar_ocultar_popup_adicionar_atividade();
	}
}
