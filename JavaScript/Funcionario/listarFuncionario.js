
//Script com funções gerais (loading)
document.write(unescape('%3Cscript src="../../JavaScript/Geral/geral.js" type="text/javascript"%3E%3C/script%3E'));

//Script com funções gerais para listas
document.write(unescape('%3Cscript src="../../JavaScript/Geral/listas.js" type="text/javascript"%3E%3C/script%3E'));


//3 problemas
//Separar os resultados em paginas
//Filtrar os dados
//Ordenar os dados

$(document).ready(() => {
    Loading(true);

    let metodo = "metodoFuncionario";
    let valor = "Listar";
    let post = `${metodo}=${valor}`;

    let lista;
    let numeroPaginas;

    $.ajax({
        type: 'POST',
        url: "../../Controllers/FuncionarioController.php",
        data: post,
        dataType: 'json',
        success: dados => {
            if (dados.hasOwnProperty("erro")) {
                Loading(false);
                AcionarModalErro("Erro", dados.erro, "bg-danger");
            } else {
                lista = dados.lista;
                numeroPaginas = Math.ceil(lista.length / 25);

                GerarTabela(lista, 1);

                GerarPaginacao(numeroPaginas);

                Loading(false);
            }
        },
        error: erro => {
            Loading(false);

            AcionarModalErro("Erro", erro.statusText, "bg-danger");
        }
    });

    HabilitarAlteracaoPagina();

    $('#pagina').on("change", e => {
        let paginaAtual = $(e.target).val();

        GerarTabela(lista, paginaAtual);

        $('html, body').scrollTop(0);

        HabilitarSetas(numeroPaginas);
    });
});

//Gera a tabela de acordo om a pagina passada
function GerarTabela(listaCompleta, pagina) {
    let listaPaginada = listar(listaCompleta, pagina);

    $('tbody').html("");

    $.each(listaPaginada, (i, funcionario) => {
        let nivelAcesso = DefinirNivelAcesso(funcionario.NivelAcesso);

        let colunas = {
            1: i + 1,
            2: funcionario.Nome,
            3: nivelAcesso
        };

        let actions = {
            detalhes: {
                type: 'a',
                href: `Detalhes.php?funcionario=${funcionario.Id}&usuario=${funcionario.UsuarioId}`,
                html: "Detalhes"
            },
            editar: {
                type: 'a',
                href: `Editar.php?funcionario=${funcionario.Id}&usuario=${funcionario.UsuarioId}`,
                html: "Editar"
            },
            deletar: {
                type: 'button',
                value: `funcionario=${funcionario.Id}&usuario=${funcionario.UsuarioId}`,
                html: "Deletar"
            }
        };

        let linha = CriarLinhaTabela(colunas, actions);

        $('tbody').append(linha);
    });
}