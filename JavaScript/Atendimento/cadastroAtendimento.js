document.write(unescape('%3Cscript src="../../JavaScript/Geral/formularios.js" type="text/javascript"%3E%3C/script%3E'));

function ValidarForm() {

    var hora = document.getElementById('hora');
    var data = document.getElementById('data');

    var mensagemHora = ValidarHora(hora, data);
    var mensagemData = ValidarData(data);

    hora.setCustomValidity(mensagemHora);
    data.setCustomValidity(mensagemData);

    document.getElementById('erroHora').innerHTML = hora.validationMessage;
    document.getElementById('erroData').innerHTML = data.validationMessage;
}

function ValidarData(input) {
    var dataDigitada = new Date(input.value);
    var dataAtual = new Date();

    if (dataDigitada > dataAtual) {
        return "A data deve ser menor ou igual que a data atual";
    } else {
        return "";
    }
}

function ValidarHora(hora, data) {
    var dataDigitada = new Date(data.value);
    var dataAtual = new Date();

    var horaDigitada = hora.value;
    var horaAtual = "" + dataAtual.getHours() + ":" + dataAtual.getMinutes();

    dataAtual = "" + dataAtual.getDate() + "/" + dataAtual.getMonth() + "/" + dataAtual.getYear();
    dataDigitada = "" + (dataDigitada.getDate() + 1) + "/" + dataDigitada.getMonth() + "/" + dataDigitada.getYear();

    if (dataDigitada === dataAtual) {
        if (horaDigitada > horaAtual) {
            return "A hora deve ser menor ou igual que a hora atual";
        } else {
            return "";
        }
    } else {
        return "";
    }
}
