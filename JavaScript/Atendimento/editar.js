
//Script com funções gerais (loading)
document.write(unescape('%3Cscript src="../../JavaScript/Geral/geral.js" type="text/javascript"%3E%3C/script%3E'));

//Script para fazer validação de formularios
document.write(unescape('%3Cscript src="../../JavaScript/validate.min.js" type="text/javascript"%3E%3C/script%3E'));

//Script para definir as mensagens padrões da validação
document.write(unescape('%3Cscript src="../../JavaScript/validateMessage.js" type="text/javascript"%3E%3C/script%3E'));

//Script necessario para edição de formularios
document.write(unescape('%3Cscript src="../../JavaScript/Geral/editar.js" type="text/javascript"%3E%3C/script%3E'));

//Script necessario para a inclusão e remoção de sintomas
document.write(unescape('%3Cscript src="../../JavaScript/Atendimento/geral.js" type="text/javascript"%3E%3C/script%3E'));


$(document).ready(() => {
    
    ValidarNivelAcesso(3);
    
    Loading(true);

    let numeroSintomas = new Array();

    let metodo = "metodoAtendimento";
    let valor = "GetAtendimento";
    let post = `${metodo}=${valor}&${location.search.slice(1)}`;

    $.ajax({
        type: 'POST',
        url: "../../Controllers/AtendimentoController.php",
        data: post,
        dataType: 'json',
        success: dados => {
            if (dados.hasOwnProperty("erro")) {
                Loading(false);
                AcionarModalErro("Erro", dados.erro, "bg-danger");
            } else {

                //Preencher dados do paciente
                let paciente = dados.paciente;

                $('#nome').val(paciente.nome);
                $('#ra').val(paciente.ra);

                //Preencher o atendimento
                let atendimento = dados.atendimento;

                ListarFuncionarios($('#atendente'), atendimento.funcionario, true);
                $('#hora').val(atendimento.hora);
                $('#data').val(atendimento.data);
                $('#procedimento').val(atendimento.procedimento);


                //Preencher os sintomas
                let sintomas = dados.sintomas;

                $.each(sintomas, (i, valor) => {

                    if (i === 0) {
                        CriarSintoma(i + 1, false, valor.SintomaId, valor.Id);
                    } else {
                        CriarSintoma(i + 1, true, valor.SintomaId, valor.Id);
                    }

                    $(`#especificacao${i + 1}`).val(valor.Especificacao);

                    numeroSintomas.push('ocupado');
                });

                Loading(false);
            }
        },
        error: erro => {
            Loading(false);

            AcionarModalErro("Erro", erro.statusText, "bg-danger");
        }
    });

    //Libera a adição e remoção de sintomas
    AdicionarRemover(numeroSintomas);

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

    let controller = {
        controller: "../../Controllers/AtendimentoController.php", //Url para o controller
        metodo: "metodoAtendimento", //qual o tipo de metodo (metodo seguido do nome do controller)
        valor: "Editar" //Nome do metodo que irá executar
    };

    //Envio do formulario para a edição
    $('form.needs-validation').on("Enviar", e => {
        Loading(true);

        let dados = $(e.target).serialize();

        let metodo = controller.metodo;
        let valor = controller.valor;
        let post = `${dados}&${metodo}=${valor}&${location.search.slice(1)}`;
        post += `&numeroSintomas=${numeroSintomas.length}`;

        $.ajax({
            type: 'POST',
            url: controller.controller,
            data: post,
            dataType: 'json',
            success: dados => {
                Loading(false);

                if (dados.hasOwnProperty("erro")) {
                    AcionarModalErro("Erro", dados.erro, "bg-danger");
                } else {
                    AcionarModalErro("Sucesso", dados.sucesso, "bg-success");

                    $('#modal').on('hidden.bs.modal', () => {
                        window.location.href = "Listar.php";
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
