document.write(unescape('%3Cscript src="../../JavaScript/Geral/formularios.js" type="text/javascript"%3E%3C/script%3E'));

function ValidarForm() {

    var nome = document.getElementById('nome');
    var login = document.getElementById('login');
    var senha = document.getElementById('senha');
    var confirmarSenha = document.getElementById('confirmarSenha');


    var mensagemNome = VerificarTamanho(nome, nome.getAttribute('minlength'));
    var mensagemLogin = VerificarTamanho(login, login.getAttribute('minlength'));

    if (senha.value != '') {
        var mensagemSenha = VerificarTamanho(senha, senha.getAttribute('minlength'));
        
        senha.setCustomValidity(mensagemSenha);
    }

    if (confirmarSenha.value != '') {
        var mensagemConfirmarSenha = VerificarTamanho(confirmarSenha, confirmarSenha.getAttribute('minlength'));
        var mensagemConfirmarSenha2 = VerificarSenhas(senha, confirmarSenha);
        
        confirmarSenha.setCustomValidity((mensagemConfirmarSenha === "") ? mensagemConfirmarSenha2 : mensagemConfirmarSenha);
    }

    nome.setCustomValidity(mensagemNome);
    login.setCustomValidity(mensagemLogin);
    

    document.getElementById('erroNome').innerHTML = nome.validationMessage;
    document.getElementById('erroLogin').innerHTML = login.validationMessage;
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


