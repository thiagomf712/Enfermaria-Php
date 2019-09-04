
//Script com funções gerais (loading)
document.write(unescape('%3Cscript src="../../JavaScript/Geral/geral.js" type="text/javascript"%3E%3C/script%3E'));

$(document).ready(() => {
    Loading(true);

    let metodo = "metodoAtendimento";
    let valor = "GetFichaMedica";
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
                //Preencher o form com os dados
                let fichaMedica = dados.resultado;

                let paciente = ParametroToObjetct(location.search.slice(1));

                $('#nome').val(paciente.nome);
                $('#ra').val(paciente.ra);

                //Ficha
                $('#plano').val(fichaMedica.planoSaude);
                $('#problema').val(fichaMedica.problemaSaude);
                $('#medicamento').val(fichaMedica.medicamento);
                $('#alergia').val(fichaMedica.alergia);
                $('#cirurgia').val(fichaMedica.cirurgia);

                Loading(false);
            }
        },
        error: erro => {
            Loading(false);

            AcionarModalErro("Erro", erro.statusText, "bg-danger");
        }
    });
});



