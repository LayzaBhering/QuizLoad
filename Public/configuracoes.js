// Variáveis
let modo_pergunta = document.getElementsByClassName("pergunta-modo");
let pergunta_aleatoria = document.getElementsByClassName("pergunta-aleatoria");
let alternativa_aleatoria = document.getElementsByClassName("alternativa-aleatoria");
let duracao = document.getElementById("duracao");

let elementos_formulario = document.getElementsByClassName("elementos-formulario");
let elemento_botao = document.getElementById("botao");

// Funções
let modo_pergunta_selecionado = false;
let funcao_modo_pergunta_selecionado = function(elemento_atual){
	if(modo_pergunta_selecionado == false){
		modo_pergunta_selecionado = elemento_atual;

		elemento_atual.childNodes[1].src = elemento_atual.childNodes[1].src.replace("nocheck", "check");
		elemento_atual.childNodes[3].classList.add("text-decoration-underline");
		elemento_atual.childNodes[3].classList.add("fw-bold");
		elementos_formulario[0].value = elemento_atual.childNodes[3].textContent;
	}
	else if(modo_pergunta_selecionado != elemento_atual){
		modo_pergunta_selecionado.childNodes[1].src = modo_pergunta_selecionado.childNodes[1].src.replace("check", "nocheck");
		modo_pergunta_selecionado.childNodes[3].classList.remove("text-decoration-underline");
		modo_pergunta_selecionado.childNodes[3].classList.remove("fw-bold");

		modo_pergunta_selecionado = elemento_atual;

		elemento_atual.childNodes[1].src = elemento_atual.childNodes[1].src.replace("nocheck", "check");
		elemento_atual.childNodes[3].classList.add("text-decoration-underline");
		elemento_atual.childNodes[3].classList.add("fw-bold");
		elementos_formulario[0].value = elemento_atual.childNodes[3].textContent;
	}
}

let pergunta_aleatoria_selecionada= false;
let funcao_pergunta_selecionado = function(elemento_atual){
	if(pergunta_aleatoria_selecionada == false){
		pergunta_aleatoria_selecionada = elemento_atual;

		elemento_atual.childNodes[1].src = elemento_atual.childNodes[1].src.replace("nocheck", "check");
		elemento_atual.childNodes[3].classList.add("text-decoration-underline");
		elemento_atual.childNodes[3].classList.add("fw-bold");
		elementos_formulario[1].value = elemento_atual.childNodes[3].dataset.valor;
	}
	else if(pergunta_aleatoria_selecionada != elemento_atual){
		pergunta_aleatoria_selecionada.childNodes[1].src = pergunta_aleatoria_selecionada.childNodes[1].src.replace("check", "nocheck");
		pergunta_aleatoria_selecionada.childNodes[3].classList.remove("text-decoration-underline");
		pergunta_aleatoria_selecionada.childNodes[3].classList.remove("fw-bold");

		pergunta_aleatoria_selecionada = elemento_atual;

		elemento_atual.childNodes[1].src = elemento_atual.childNodes[1].src.replace("nocheck", "check");
		elemento_atual.childNodes[3].classList.add("text-decoration-underline");
		elemento_atual.childNodes[3].classList.add("fw-bold");
		elementos_formulario[1].value = elemento_atual.childNodes[3].dataset.valor;
	}
}

let alternativa_aleatoria_selecionada= false;
let funcao_alternativa_selecionado = function(elemento_atual){
	if(alternativa_aleatoria_selecionada == false){
		alternativa_aleatoria_selecionada = elemento_atual;

		elemento_atual.childNodes[1].src = elemento_atual.childNodes[1].src.replace("nocheck", "check");
		elemento_atual.childNodes[3].classList.add("text-decoration-underline");
		elemento_atual.childNodes[3].classList.add("fw-bold");
		elementos_formulario[2].value = elemento_atual.childNodes[3].dataset.valor;
	}
	else if(alternativa_aleatoria_selecionada != elemento_atual){
		alternativa_aleatoria_selecionada.childNodes[1].src = alternativa_aleatoria_selecionada.childNodes[1].src.replace("check", "nocheck");
		alternativa_aleatoria_selecionada.childNodes[3].classList.remove("text-decoration-underline");
		alternativa_aleatoria_selecionada.childNodes[3].classList.remove("fw-bold");

		alternativa_aleatoria_selecionada = elemento_atual;

		elemento_atual.childNodes[1].src = elemento_atual.childNodes[1].src.replace("nocheck", "check");
		elemento_atual.childNodes[3].classList.add("text-decoration-underline");
		elemento_atual.childNodes[3].classList.add("fw-bold");
		elementos_formulario[2].value = elemento_atual.childNodes[3].dataset.valor;
	}
}

// Adicionadno evento aos elementos

// Adicionando evento ao modo pergunta
for(var contador = 0; contador < modo_pergunta.length; contador++){
	modo_pergunta[contador].addEventListener("click", function(){
		funcao_modo_pergunta_selecionado(this);
	});
}
// Adicionadno evento ao pergunta aleatoria
for(var contador = 0; contador < pergunta_aleatoria.length; contador++){
	pergunta_aleatoria[contador].addEventListener("click", function(){
		funcao_pergunta_selecionado(this);
	});
}
//
for(var contador = 0; contador < alternativa_aleatoria.length; contador++){
	alternativa_aleatoria[contador].addEventListener("click", function(){
		funcao_alternativa_selecionado(this);
	});
}

duracao.addEventListener('change', () => {elementos_formulario[3].value = duracao.value});

// Carregando informações enviada pelo servidor
if(configuracoes.modo == 'Normal'){
	modo_pergunta[0].click();
}
else{
	modo_pergunta[1].click();
}

if(configuracoes.perguntas == 1){
	pergunta_aleatoria[0].click();
}
else{
	pergunta_aleatoria[1].click();
}

if(configuracoes.alternativas== 1){
	alternativa_aleatoria[0].click();
}
else{
	alternativa_aleatoria[1].click();
}

duracao.value = configuracoes.duracao;