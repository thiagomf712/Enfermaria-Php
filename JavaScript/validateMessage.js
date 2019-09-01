jQuery.extend(jQuery.validator.messages, {
    required: "O campo deve ser preenchido",
    //remote: "Please fix this field.",
    email: "Digite um email válido",
    url: "Digite uma URL válida",
    date: "Digite uma data válida",
    //dateISO: "Please enter a valid date (ISO).",
    number: "Digite um número válido (ponto como decimal)",
    digits: "Só deve ser digitado números",
    //creditcard: "Please enter a valid credit card number.",
    equalTo: "Digite o mesmo valor",
    //accept: "Selecione um ",
    maxlength: jQuery.validator.format("O campo deve ter menos que {0} caracteres."),
    minlength: jQuery.validator.format("O campo deve ter mais que {0} caracteres."),
    rangelength: jQuery.validator.format("O campo deve ter entre {0} e {1} caracteres"),
    range: jQuery.validator.format("Deve ser digitado um valor entre {0} e {1}."),
    max: jQuery.validator.format("Deve ser digitado um valor menor ou igual que {0}."),
    min: jQuery.validator.format("Deve ser digitado um valor maior ou igual que {0}.")
});