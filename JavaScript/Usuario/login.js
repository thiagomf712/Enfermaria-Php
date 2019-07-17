document.write(unescape('%3Cscript src="../../JavaScript/Geral/formularios.js" type="text/javascript"%3E%3C/script%3E'));

function ValidarForm(loginId, senhaId) {
    var login = document.getElementById(loginId);
    var senha = document.getElementById(senhaId);

    var mensagemLogin = VerificarTamanho(login, login.getAttribute('minlength'));
    var mensagemSenha = VerificarTamanho(senha, senha.getAttribute('minlength'));

    login.setCustomValidity(mensagemLogin);
    senha.setCustomValidity(mensagemSenha);

    document.getElementById('erroLogin').innerHTML = login.validationMessage;
    document.getElementById('erroSenha').innerHTML = senha.validationMessage;
}




