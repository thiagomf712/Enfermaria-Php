//Script com funções pada cadastro
document.write(unescape('%3Cscript src="../../JavaScript/Geral/cadastro.js" type="text/javascript"%3E%3C/script%3E'));

//Script com funções gerais (loading)
document.write(unescape('%3Cscript src="../../JavaScript/Geral/geral.js" type="text/javascript"%3E%3C/script%3E'));

//Script para fazer validação de formularios
document.write(unescape('%3Cscript src="../../JavaScript/validate.min.js" type="text/javascript"%3E%3C/script%3E'));

//Script para definir as mensagens padrões da validação
document.write(unescape('%3Cscript src="../../JavaScript/validateMessage.js" type="text/javascript"%3E%3C/script%3E'));


$(document).ready(() => {
    
    ValidarNivelAcesso(2);

    AlterarEndereco();
    
    let inputLongo = {
        maxlength: 100
    };
    let inputMedio = {
        maxlength: 50
    };

    $('form.needs-validation').validate({
        submitHandler: function (form) {
            $(form).trigger("Enviar");
        },
        onfocusout: function (element) {
            $(element).valid();
        },
        errorPlacement: function (error, element) {
            error.addClass("invalid-feedback");
            error.insertAfter(element);
        },
        errorClass: "is-invalid",
        validClass: "is-valid",

        rules: {
            nome: {
                required: true,
                minlength: 3,
                maxlength: 50
            },
            ra: {
                required: true,
                min: 1
            },
            dataNascimento: {
                required: true,
                date: true,
                max: DefinirData(0),
                min: DefinirData(100)
            },
            email: {
                email: true,
                maxlength: 50
            },
            telefone: {
                maxlength: 15
            },
            planoSaude: inputLongo,
            problemaSaude: inputLongo,
            medicamento: inputLongo,
            alergia: inputLongo,
            cirurgia: inputLongo,
            rua: inputMedio,
            numero: {
                min: 1,
                max: 9999
            },
            complemento: {
                maxlength: 20
            },
            cep: {
                maxlength: 9
            },
            bairro: inputMedio,
            cidade: inputMedio,
            estado: inputMedio
        }
    });

    let controller = {
        controller: "../../Controllers/PacienteController.php", //Url para o controller
        metodo: "metodoPaciente", //qual o tipo de metodo (metodo seguido do nome do controller)
        valor: "Cadastrar" //Nome do metodo que irá executar
    };

    EfetuarCadastro(controller);
});

//Faz alteração do endereço automaticamente ao mudar o regime
function AlterarEndereco() {
    $("#interno, #externo").on('change', e => {
        if ($(e.target).val() === "1") {
            $('#rua').val("Estr. Mun. Pastor Walter Boger");
            $('#numero').val("");
            $('#complemento').val("");
            $('#cep').val("13445-970");
            $('#bairro').val("Lagoa Bonita I");
            $('#cidade').val("Engenheiro Coelho");
            $('#estado').val("São Paulo");
        } else {
            $('#rua').val("");
            $('#numero').val("");
            $('#complemento').val("");
            $('#cep').val("");
            $('#bairro').val("");
            $('#cidade').val("");
            $('#estado').val("");
        }
    });
}

function DefinirData(diferenca) {
    let dataAtual = new Date();
    
    let dia = dataAtual.getDate();
    let mes = dataAtual.getMonth() + 1;
    let ano = dataAtual.getFullYear();
    
    return (mes < 10) ? `${ano - diferenca}-0${mes}-${dia}` : `${ano - diferenca}-${mes}-${dia}`;
}