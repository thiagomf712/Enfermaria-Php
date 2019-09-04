//Script com funções pada cadastro
document.write(unescape('%3Cscript src="../../JavaScript/Geral/cadastro.js" type="text/javascript"%3E%3C/script%3E'));

//Script com funções gerais (loading)
document.write(unescape('%3Cscript src="../../JavaScript/Geral/geral.js" type="text/javascript"%3E%3C/script%3E'));

//Script para fazer validação de formularios
document.write(unescape('%3Cscript src="../../JavaScript/validate.min.js" type="text/javascript"%3E%3C/script%3E'));

//Script para definir as mensagens padrões da validação
document.write(unescape('%3Cscript src="../../JavaScript/validateMessage.js" type="text/javascript"%3E%3C/script%3E'));

//Script necessario para a inclusão e remoção de sintomas
document.write(unescape('%3Cscript src="../../JavaScript/Atendimento/geral.js" type="text/javascript"%3E%3C/script%3E'));


$(document).ready(() => {
    
    ValidarNivelAcesso(2);

    let numeroSintomas = ['ocupado'];

    //Validação
    jQuery.validator.addMethod("hora", (valor, elemento) => {
        return ValidarHora(valor);
    });

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
            hora: {
                required: true,
                hora: true
            },
            data: {
                required: true,
                date: true,
                max: DefinirData(0),
                min: DefinirData(100)
            },
            procedimento: {
                maxlength: 100
            },
            telefone: {
                maxlength: 15
            }
        },

        messages: {
            hora: {
                hora: "Não deve ser digitado uma data futura"
            }
        }
    });

    //Preencher os atendentes
    ListarFuncionarios($('#atendente'), $('#usuarioAtual').val());

    //Preencher as informações do paciente no topo
    DadosPaciente();

    //Cria o primeiro sintoma
    CriarSintoma(1, false);

    //Libera a adição e remoção de sintomas
    AdicionarRemover(numeroSintomas);

    let controller = {
        controller: "../../Controllers/AtendimentoController.php", //Url para o controller
        metodo: "metodoAtendimento", //qual o tipo de metodo (metodo seguido do nome do controller)
        valor: "Cadastrar" //Nome do metodo que irá executar
    };

    //Efetuar o cadastro
    $('form.needs-validation').on("Enviar", e => {
        Loading(true);

        let dados = $(e.target).serialize();

        let metodo = controller.metodo;
        let valor = controller.valor;

        let paciente = ParametroToObjetct(location.search.slice(1));
        dados += `&${metodo}=${valor}`;
        dados += `&paciente=${paciente.paciente}&numeroSintomas=${numeroSintomas.length}`;

        $.ajax({
            type: 'POST',
            url: controller.controller,
            data: dados,
            dataType: 'json',
            success: dados => {
                Loading(false);

                if (dados.hasOwnProperty("erro")) {
                    AcionarModalErro("Erro", dados.erro, "bg-danger");
                } else {
                    AcionarModalErro("Sucesso", dados.sucesso, "bg-success");

                    $('#modal').on('hidden.bs.modal', () => {
                        location.href = "ListaPacientes.php";
                    });
                }
            },
            error: erro => {
                Loading(false);

                AcionarModalErro("Erro", erro.statusText, "bg-danger");
            }
        });
    });
});


function DefinirData(diferenca) {
    let dataAtual = new Date();

    let dia = dataAtual.getDate();
    let mes = dataAtual.getMonth() + 1;
    let ano = dataAtual.getFullYear();

    if (dia < 10) {
        dia = `0${dia}`;
    }

    return (mes < 10) ? `${ano - diferenca}-0${mes}-${dia}` : `${ano - diferenca}-${mes}-${dia}`;
}

function ValidarHora(hora) {
    var dataDigitada = new Date($('#data').val());
    var dataAtual = new Date();

    var horaDigitada = hora;
    var horaAtual = "" + dataAtual.getHours() + ":" + dataAtual.getMinutes();

    dataAtual = "" + dataAtual.getDate() + "/" + dataAtual.getMonth() + "/" + dataAtual.getYear();
    dataDigitada = "" + (dataDigitada.getDate() + 1) + "/" + dataDigitada.getMonth() + "/" + dataDigitada.getYear();

    if (dataDigitada === dataAtual) {
        if (horaDigitada > horaAtual) {
            return false;
        }
    }

    return true;
}