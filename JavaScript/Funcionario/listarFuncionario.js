
//Script com funções gerais (loading)
document.write(unescape('%3Cscript src="../../JavaScript/Geral/geral.js" type="text/javascript"%3E%3C/script%3E'));

//Script com funções gerais para listas
document.write(unescape('%3Cscript src="../../JavaScript/Geral/listas.js" type="text/javascript"%3E%3C/script%3E'));

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

                //Gera a tabela inicial (25 primeiros resultados)
                GerarTabela(lista, 1);

                //Gera e habilita a paginação
                GerarPaginacao(numeroPaginas);

                //Habilitas as alterações de pagina pelas setas
                HabilitarAlteracaoPaginaSetas();

                //Habilitas as alterações de pagina pelo select
                HabilitarAlteracaoPaginaSelect(lista, numeroPaginas);

                //Habilita a ordenação de lista
                Ordenar(lista, {
                    1: {
                        id: "order-id",
                        atributo: "Id",
                        type: "numero"
                    },
                    2: {
                        id: "order-nome",
                        atributo: "Nome",
                        type: "string"
                    },
                    3: {
                        id: "order-nivelAcesso",
                        atributo: "NivelAcesso",
                        type: "numero"
                    }
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

//Gera a tabela de acordo om a pagina passada
function GerarTabela(listaCompleta, pagina) {
    let listaPaginada = listar(listaCompleta, pagina);

    $('tbody').html("");

    $.each(listaPaginada, (i, funcionario) => {
        let nivelAcesso = DefinirNivelAcesso(funcionario.NivelAcesso);

        let numeros = (parseInt(pagina) - 1) * 25 + (i + 1);

        let colunas = {
            1: numeros,
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