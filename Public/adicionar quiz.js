// Criando variáveis
let elemento_pergunta_texto = document.getElementById("elemento-pergunta-texto");
let elemento_pergunta_input = document.getElementById("elemento-pergunta-input");

let elementos_alternativa_texto = document.getElementsByClassName("elemento-alternativas-texto");
let elementos_alternativa_input = document.getElementsByClassName("elemento-alternativas-input");
let elementos_alternativa_check = document.getElementsByClassName("elemento-alternativas-check");
let elementos_alternativa_corretas = document.getElementById("elemento-alternativas-corretas");

// Adicionando eventos

// Adicionando evento ao clicar na pergunta
let controle_display_pergunta_texto = "block";
elemento_pergunta_texto.addEventListener("click", function(){
	if(controle_display_pergunta_texto == "block"){ elemento_pergunta_texto.classList.add("d-none"); elemento_pergunta_input.classList.remove("d-none");
		elemento_pergunta_input.focus();
		controle_display_pergunta_texto = "none";
	}
});

elemento_pergunta_input.addEventListener("blur", function(){
	if(controle_display_pergunta_texto == "none"){
		if(elemento_pergunta_input.value == ""){
			elemento_pergunta_texto.innerHTML= "Adicione a pergunta aqui (clique aqui)";
		}
		else{
			elemento_pergunta_texto.innerHTML = elemento_pergunta_input.value;
		}
		elemento_pergunta_texto.classList.remove("d-none");
		elemento_pergunta_input.classList.add("d-none");
		controle_display_pergunta_texto = "block";
	}
});

let controle_alternativa_anterior=["", "", ""];

for(let contador=0; contador < elementos_alternativa_texto.length; contador++){

	// Adicionando evento ao clicar nas alternativas
	elementos_alternativa_texto[contador].addEventListener("click", function(){
		elementos_alternativa_texto[contador].classList.add("d-none");
		elementos_alternativa_input[contador].classList.remove("d-none");
		elementos_alternativa_input[contador].focus();
		controle_alternativa_anterior[0] = elementos_alternativa_texto[contador]; // Elemento texto
		controle_alternativa_anterior[1] = elementos_alternativa_input[contador]; // Elemento input
		controle_alternativa_anterior[2] = 0; // ID
	});

	// Adicionando evento ao desfocar nas alternativas
	elementos_alternativa_input[contador].addEventListener("blur", function(){
		if(controle_alternativa_anterior[1].value == ""){
			controle_alternativa_anterior[0].innerHTML = "Adicione Alternativa "+(contador+1);
			elementos_alternativa_check[contador].classList.add("d-none");

			// Desmarcando o check, caso ele esteja marcado
			if(elementos_alternativa_check[contador].src.indexOf("nocheck") == -1){
				elementos_alternativa_check[contador].src = elementos_alternativa_check[contador].src.replace("check", "nocheck");
			}
		}else{
			controle_alternativa_anterior[0].innerHTML = controle_alternativa_anterior[1].value; // Passando o texto do input para o texto
			elementos_alternativa_check[contador].classList.remove("d-none");
		}
		controle_alternativa_anterior[0].classList.remove("d-none"); // Elemento texto
		controle_alternativa_anterior[1].classList.add("d-none"); // Elemento input
		controle_alternativa_anterior[0] = ""; // Elemento texto
		controle_alternativa_anterior[1] = ""; // Elemento input
		controle_alternativa_anterior[2] = ""; // ID
	});
}

for(let contador = 0; contador < elementos_alternativa_check.length; contador++){
	elementos_alternativa_check[contador].addEventListener("click", function(){
		if(elementos_alternativa_check[contador].src.indexOf("nocheck") != -1){
			elementos_alternativa_check[contador].src = elementos_alternativa_check[contador].src.replace("nocheck", "check");
			elementos_alternativa_corretas.value = elementos_alternativa_corretas.value + contador;
		}	
		else{
			elementos_alternativa_check[contador].src = elementos_alternativa_check[contador].src.replace("check", "nocheck");
			elementos_alternativa_corretas.value = elementos_alternativa_corretas.value.replace(contador, "");
		}
	});
}
