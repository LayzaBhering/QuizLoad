// Variáveis
let icones = document.getElementsByClassName("icones");
let campo_pergunta = document.getElementsByClassName("campo-pergunta");
let opcoes_elemento_selecionado = document.getElementById("opcoes-pergunta-selecionada");

// Funções
let elemento_campo_pergunta_selecionado = false;
let funcao_selecionar_campo_pergunta = function(elemento_atual){
	
	elemento_atual.classList.add("border");

	if(elemento_campo_pergunta_selecionado == false){
		elemento_campo_pergunta_selecionado = elemento_atual;
		opcoes_elemento_selecionado.classList.remove("opacity-25");
	}
	else if(elemento_campo_pergunta_selecionado == elemento_atual){
		elemento_atual.classList.remove("border");
		elemento_campo_pergunta_selecionado = false;
		opcoes_elemento_selecionado.classList.add("opacity-25");
	}
	else{
		elemento_campo_pergunta_selecionado.classList.remove("border");
		elemento_campo_pergunta_selecionado = elemento_atual;
		opcoes_elemento_selecionado.classList.remove("opacity-25");
	}
}

// Adicionando evento aos elementos

// Adicionando evento nos ícones
icones[0].addEventListener("click", ()=>{
	if(elemento_campo_pergunta_selecionado != false){
		funcao_selecionar_campo_pergunta(elemento_campo_pergunta_selecionado);
	}
});

icones[1].addEventListener("click", ()=>{
	if(elemento_campo_pergunta_selecionado != false){
		funcao_selecionar_campo_pergunta(elemento_campo_pergunta_selecionado);
	}
});

// Adicionando evento nos campo de perguntas
let contador_interno=0
for(var contador=0; contador < campo_pergunta.length; contador++){
	campo_pergunta[contador].addEventListener("click", function(){
		funcao_selecionar_campo_pergunta(this);
	});
}
