function ValidarForm(loginId, senhaId) {
    var login = document.getElementById(loginId);
    var senha = document.getElementById(senhaId);

    VerificarTamanho(login, login.getAttribute('minlength'));
    VerificarTamanho(senha, senha.getAttribute('minlength'));

    document.getElementById('erroLogin').innerHTML = login.validationMessage;
    document.getElementById('erroSenha').innerHTML = senha.validationMessage;
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



