document.write(unescape('%3Cscript src="../../JavaScript/Geral/formularios.js" type="text/javascript"%3E%3C/script%3E'));

function ValidarForm() {

    var nome = document.getElementById('nome');
    var login = document.getElementById('login');
    var senha = document.getElementById('senha');
    var confirmarSenha = document.getElementById('confirmarSenha');


    var mensagemNome = VerificarTamanho(nome, nome.getAttribute('minlength'));
    var mensagemLogin = VerificarTamanho(login, login.getAttribute('minlength'));
    var mensagemSenha = VerificarTamanho(senha, senha.getAttribute('minlength'));

    var mensagemConfirmarSenha = VerificarTamanho(confirmarSenha, confirmarSenha.getAttribute('minlength'));
    var mensagemConfirmarSenha2 = VerificarSenhas(senha, confirmarSenha);

    nome.setCustomValidity(mensagemNome);
    login.setCustomValidity(mensagemLogin);
    senha.setCustomValidity(mensagemSenha);
    
    //isso é feito por que é feito duas verificações diferentes no ConfirmarSenhas
    confirmarSenha.setCustomValidity((mensagemConfirmarSenha === "") ? mensagemConfirmarSenha2 : mensagemConfirmarSenha);


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
