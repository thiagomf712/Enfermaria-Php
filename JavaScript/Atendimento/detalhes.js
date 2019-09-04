
//Script com funções gerais (loading)
document.write(unescape('%3Cscript src="../../JavaScript/Geral/geral.js" type="text/javascript"%3E%3C/script%3E'));

//Script necessario para a inclusão e remoção de sintomas
document.write(unescape('%3Cscript src="../../JavaScript/Atendimento/geral.js" type="text/javascript"%3E%3C/script%3E'));


$(document).ready(() => {
    Loading(true);

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
                    CriarSintoma(i + 1, false, valor.SintomaId);

                    $(`#especificacao${i + 1}`).val(valor.Especificacao);
                });

                Loading(false);
            }
        },
        error: erro => {
            Loading(false);

            AcionarModalErro("Erro", erro.statusText, "bg-danger");
        }
    });
});



