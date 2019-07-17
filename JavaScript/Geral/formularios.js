function VerificarTamanho(input, min) {
    if (input.value.length === 0) {
        return "O campo deve ser preenchido";
    } else if (input.value.length < min) {
        return "O tamanho deve ser maior que " + min + " caracteres";
    } else {
        return "";
    }
}
