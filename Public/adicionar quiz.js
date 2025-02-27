// Criando variáveis
let elemento_pergunta = document.getElementById("elemento-pergunta");

let contador_alternativas = 0;
let elementos_alternativa = document.getElementsByClassName("elemento-alternativas");

// Adicionando eventos
elemento_pergunta.addEventListener("click", function(){alert("clicou")});
elementos_alternativa[0].addEventListener("click", function(){alert("clicou")});
