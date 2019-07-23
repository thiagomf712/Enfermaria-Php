document.write(unescape('%3Cscript src="../../JavaScript/Geral/formularios.js" type="text/javascript"%3E%3C/script%3E'));

function ValidarForm() {
    var senha = document.getElementById('senha');
    var confirmarSenha = document.getElementById('confirmarSenha');


    var mensagemSenha = VerificarTamanho(senha, senha.getAttribute('minlength'));
    var mensagemConfirmarSenha = VerificarTamanho(confirmarSenha, confirmarSenha.getAttribute('minlength'));
    var mensagemConfirmarSenha2 = VerificarSenhas(senha, confirmarSenha);


    senha.setCustomValidity(mensagemSenha);
    confirmarSenha.setCustomValidity((mensagemConfirmarSenha === "") ? mensagemConfirmarSenha2 : mensagemConfirmarSenha);


    document.getElementById('erroSenha').innerHTML = senha.validationMessage;
    document.getElementById('erroConfirmarSenha').innerHTML = confirmarSenha.validationMessage;
}

function VerificarSenhas(senha, confirmar) {
    if (senha.value !== confirmar.value) {
        return "As senhas não são iguais";
    } else {
        return "";
    }
}


