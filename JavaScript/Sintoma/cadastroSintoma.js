document.write(unescape('%3Cscript src="../../JavaScript/Geral/formularios.js" type="text/javascript"%3E%3C/script%3E'));

function ValidarForm() {
    var nome = document.getElementById('nome');

    var mensagemNome = VerificarTamanho(nome, nome.getAttribute('minlength'));

    nome.setCustomValidity(mensagemNome);

    document.getElementById('erroNome').innerHTML = nome.validationMessage;
}




