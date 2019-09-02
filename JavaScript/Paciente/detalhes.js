
//Script com funções gerais (loading)
document.write(unescape('%3Cscript src="../../JavaScript/Geral/geral.js" type="text/javascript"%3E%3C/script%3E'));

$(document).ready(() => {
    Loading(true);

    let metodo = "metodoPaciente";
    let valor = "GetPaciente";
    let post = `${metodo}=${valor}&${location.search.slice(1)}`;

    $.ajax({
        type: 'POST',
        url: "../../Controllers/PacienteController.php",
        data: post,
        dataType: 'json',
        success: dados => {
            if (dados.hasOwnProperty("erro")) {
                Loading(false);
                AcionarModalErro("Erro", dados.erro, "bg-danger");
            } else {
                //Preencher o form com os dados
                let paciente = dados.resultado;

                //Paciente
                $('#nome').val(paciente.nome);
                $('#ra').val(paciente.ra);
                $('#dataNascimento').val(paciente.dataNascimento);
                $('#email').val(paciente.email);
                $('#telefone').val(paciente.telefone);

                //Ficha
                $('#plano').val(paciente.fichaMedica.planoSaude);
                $('#problema').val(paciente.fichaMedica.problemaSaude);
                $('#medicamento').val(paciente.fichaMedica.medicamento);
                $('#alergia').val(paciente.fichaMedica.alergia);
                $('#cirurgia').val(paciente.fichaMedica.cirurgia);

                //Endereço
                $('#rua').val(paciente.endereco.logradouro);
                $('#numero').val(paciente.endereco.numero);
                $('#complemento').val(paciente.endereco.complemento);
                $('#cep').val(paciente.endereco.cep);
                $('#bairro').val(paciente.endereco.bairro);
                $('#cidade').val(paciente.endereco.cidade);
                $('#estado').val(paciente.endereco.estado);

                if (paciente.endereco.regime === 1) {
                    $('#interno').attr('checked', 'checked');
                } else {
                    $('#externo').attr('checked', 'checked');
                }

                Loading(false);
            }
        },
        error: erro => {
            Loading(false);

            AcionarModalErro("Erro", erro.statusText, "bg-danger");
        }
    });
});
