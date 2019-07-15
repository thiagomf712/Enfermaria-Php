function ValidarForm(nomeId, loginId, senhaId, confirmarSenhaId) {
   
    var nome = document.getElementById(nomeId);
    var login = document.getElementById(loginId);
    var senha = document.getElementById(senhaId);
    var confirmarSenha = document.getElementById(confirmarSenhaId);

    VerificarTamanho(nome, nome.getAttribute('minlength'));
    VerificarTamanho(login, login.getAttribute('minlength'));
    VerificarTamanho(senha, senha.getAttribute('minlength'));
    VerificarTamanho(confirmarSenha, confirmarSenha.getAttribute('minlength'));

    VerificarSenhas(senha, confirmarSenha);

    document.getElementById('erroNome').innerHTML = nome.validationMessage;
    document.getElementById('erroLogin').innerHTML = login.validationMessage;
    document.getElementById('erroSenha').innerHTML = senha.validationMessage;
    document.getElementById('erroConfirmarSenha').innerHTML = confirmarSenha.validationMessage;
}

function VerificarTamanho(input, min) {
    if (input.value.length === 0) {
        input.setCustomValidity("Deve ser digitado alguma coisa");
    } else if (input.value.length < min) {
        input.setCustomValidity("O tamanho deve ser maior que " + min + " caracteres");
    } else {
        input.setCustomValidity("");
    }
}

function VerificarSenhas(senha, confirmar) {
    if (senha.value !== confirmar.value){
        confirmar.setCustomValidity("As senhas não são iguais");
    }
    else {
        confirmar.setCustomValidity("");
    }
}
