document.write(unescape('%3Cscript src="../../JavaScript/Geral/formularios.js" type="text/javascript"%3E%3C/script%3E'));

function ValidarForm() {

    var nome = document.getElementById('nome');
    var ra = document.getElementById('ra');
    var dataNascimento = document.getElementById('dataNascimento');
    var email = document.getElementById('email');
    var telefone = document.getElementById('telefone');
    var numero = document.getElementById('numero');
    var cep = document.getElementById('cep');

    var mensagemNome = VerificarTamanho(nome, nome.getAttribute('minlength'));
    var mensagemRa = ValidarRa(ra);
    var mensagemDataNascimento = ValidarDataNascimento(dataNascimento);


    nome.setCustomValidity(mensagemNome);
    ra.setCustomValidity(mensagemRa);
    dataNascimento.setCustomValidity(mensagemDataNascimento);


    document.getElementById('erroNome').innerHTML = nome.validationMessage;
    document.getElementById('erroRa').innerHTML = ra.validationMessage;
    document.getElementById('erroDataNascimento').innerHTML = dataNascimento.validationMessage;
    document.getElementById('erroEmail').innerHTML = email.validationMessage;
    document.getElementById('erroTelefone').innerHTML = telefone.validationMessage;
    document.getElementById('erroNumero').innerHTML = numero.validationMessage;
    document.getElementById('erroCep').innerHTML = cep.validationMessage;
}

function ValidarRa(input) {
    if (input.value.length === 0) {
        return "O campo deve ser preenchido";
    } else if (input.value <= 0) {
        return "O Ra deve ser maior que 0";
    } else if (input.value.length > 11) {
        return "O Ra deve ter menos que 11 digitos";
    } else {
        return "";
    }
}

function ValidarDataNascimento(input) {
    var dataDigitada = new Date(input.value);
    var dataAtual = new Date();
    var dataMaxima = 150;

    var dia = dataAtual.getDate();
    var mes = dataAtual.getMonth() + 1;
    var ano = dataAtual.getFullYear();

    if (dataDigitada.getFullYear() <= (ano - dataMaxima))
    {
        return "A data deve ser maior que " + dia + "/" + mes + "/" + (ano - dataMaxima);
    } else if (dataDigitada > dataAtual) {
        return "A data deve ser menor que " + dia + "/" + mes + "/" + ano;
    } else {
        return "";
    }
}

function altEndereco(input) {
    if (input.value === "1") {
        document.getElementById('rua').value = "Estr. Mun. Pastor Walter Boger";
        document.getElementById('numero').value = null;
        document.getElementById('complemento').value = null;
        document.getElementById('cep').value = "13445-970";
        document.getElementById('bairro').value = "Lagoa Bonita I";
        document.getElementById('cidade').value = "Engenheiro Coelho";
        document.getElementById('estado').value = "São Paulo";
    } else if (input.value === "2") {
        document.getElementById('rua').value = null;
        document.getElementById('numero').value = null;
        document.getElementById('complemento').value = null;
        document.getElementById('cep').value = null;
        document.getElementById('bairro').value = null;
        document.getElementById('cidade').value = null;
        document.getElementById('estado').value = null;
    }
}
