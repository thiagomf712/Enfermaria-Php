
//Script com funções gerais (loading)
document.write(unescape('%3Cscript src="../../JavaScript/Geral/geral.js" type="text/javascript"%3E%3C/script%3E'));

//Script com funções gerais para listas
document.write(unescape('%3Cscript src="../../JavaScript/Geral/listas.js" type="text/javascript"%3E%3C/script%3E'));


$(document).ready(() => {

    ValidarNivelAcesso(2);

    Loading(true);

    let controller = {
        controller: "../../Controllers/EstatisticaController.php", //Url para o controller
        metodo: "metodoEstatistica", //qual o tipo de metodo (metodo seguido do nome do controller)
        valor: "GerarNumeros" //Nome do metodo que irá executar
    };

    let post = `${controller.metodo}=${controller.valor}`;

    //Gerar a numeração de todos os 3 elemetos
    $.ajax({
        type: 'POST',
        url: controller.controller,
        data: post,
        dataType: 'json',
        success: dados => {
            if (dados.hasOwnProperty("erro")) {
                Loading(false);
                AcionarModalErro("Erro", dados.erro, "bg-danger");
            } else {
                let sintomas = dados.sintomas;
                let atendimentos = dados.atendimentos;

                //A quantidade de atendimento é igual a quantidade de pacientes
                $('#numero-sintomas').html(sintomas.length);
                $('#numero-pacientes').html(atendimentos.length);
                $('#numero-atendimento').html(atendimentos.length);

                //habilitar o filtro de datas
                Filtro(sintomas, atendimentos);

                Loading(false);
            }
        },
        error: erro => {
            Loading(false);

            AcionarModalErro("Erro", erro.statusText, "bg-danger");
        }
    });

    let ordenacao = {
        Valor: {
            id: "order-valor",
            atributo: "Valor",
            type: "string"
        },
        Quantidade: {
            id: "order-quantidade",
            atributo: "Quantidade",
            type: "numero"
        }
    };

    $('#ver-sintomas').on('click', () => {
        if (parseInt($('#numero-sintomas').html()) > 0) {
            controller.valor = "GerarTabelaSintomas";

            let filtros = $('form#filtro').serializeArray();

            let parametrosExtra = `inicio=${filtros[0].value}&fim=${filtros[1].value}`;

            $('#tabela').removeClass('d-none');

            $('#coluna-valor').html("Sintoma");

            //o true está dizendo que vai ter um filtro entre duas datas
            GerarDadosTabela(ordenacao, controller, false, parametrosExtra, false);
        }
    });

    $('#ver-pacientes').on('click', () => {
        if (parseInt($('#numero-pacientes').html()) > 0) {
            controller.valor = "GerarTabelaPacientes";

            let filtros = $('form#filtro').serializeArray();

            let parametrosExtra = `inicio=${filtros[0].value}&fim=${filtros[1].value}`;

            $('#tabela').removeClass('d-none');

            $('#coluna-valor').html("Paciente");

            //o true está dizendo que vai ter um filtro entre duas datas
            GerarDadosTabela(ordenacao, controller, false, parametrosExtra, false);
        }
    });

    $('#ver-atendimentos').on('click', () => {
        if (parseInt($('#numero-atendimento').html()) > 0) {

            ordenacao.Valor.atributo = "Data";


            controller.valor = "GerarTabelaAtendimentos";

            let filtros = $('form#filtro').serializeArray();

            let parametrosExtra = `inicio=${filtros[0].value}&fim=${filtros[1].value}`;

            $('#tabela').removeClass('d-none');

            $('#coluna-valor').html("Data do atendimento");

            //o true está dizendo que vai ter um filtro entre duas datas
            GerarDadosTabela(ordenacao, controller, false, parametrosExtra, false);
        }
    });
});

//Gera a tabela de acordo om a pagina passada
function GerarTabela(listaCompleta, pagina) {
    let listaPaginada = listar(listaCompleta, pagina);

    $('tbody').html("");

    let total = 0;

    $.each(listaCompleta, (i, valor) => {
        total += parseInt(valor.Quantidade);
    });

    $.each(listaPaginada, (i, resultado) => {
        let numeros = (parseInt(pagina) - 1) * 25 + (i + 1);

        let colunas = {
            numeros: numeros
        };

        if (resultado.hasOwnProperty('Data')) {
            colunas.Valor = FormatarData(resultado.Data);
        } else {
            colunas.Valor = resultado.Valor;
        }

        colunas.Quantidade = resultado.Quantidade;

        colunas.Porcentagem = (resultado.Quantidade / total * 100).toFixed(2) + "%";

        let linha = CriarLinhaTabela(colunas, null, null);

        $('tbody').append(linha);
    });
}

function FormatarData(Data) {
    let data = new Date(Data);
    let dia = data.getDate() + 1;
    let mes = data.getMonth() + 1;
    let ano = data.getFullYear();

    if (dia < 10) {
        dia = `0${dia}`;
    }

    if (mes < 10) {
        mes = `0${mes}`;
    }

    return `${dia}/${mes}/${ano}`;
}

//Habilita a filtragem de dados nas tabelas
function Filtro(sintomas, atendimentos) {
    //Filtro
    $('form#filtro').on("submit", e => {
        e.preventDefault();

        $('#tabela').addClass('d-none');

        let filtros = $(e.target).serializeArray();

        //Filtrando listas
        let sintomasFiltrados = FiltrarDataArray(sintomas, filtros);
        let atendimentosFiltrados = FiltrarDataArray(atendimentos, filtros);

        //A quantidade de atendimento é igual a quantidade de pacientes
        $('#numero-sintomas').html(sintomasFiltrados.length);
        $('#numero-pacientes').html(atendimentosFiltrados.length);
        $('#numero-atendimento').html(atendimentosFiltrados.length);
    });

    HabilitarRemoverFiltros();
}

function FiltrarDataArray(lista, filtros) {
    let listaFiltrada = lista.filter((valor) => {
        let filtro = true;

        let inicio = filtros[0].value;
        let fim = filtros[1].value;

        if (inicio !== '') {
            filtro = filtro && valor.Data >= inicio;
        }

        if (fim !== '') {
            filtro = filtro && valor.Data <= fim;
        }

        return filtro;
    });

    return listaFiltrada;
}




