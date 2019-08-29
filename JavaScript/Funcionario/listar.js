
//Script com funções gerais (loading)
document.write(unescape('%3Cscript src="../../JavaScript/Geral/geral.js" type="text/javascript"%3E%3C/script%3E'));

//Script com funções gerais para listas
document.write(unescape('%3Cscript src="../../JavaScript/Geral/listas.js" type="text/javascript"%3E%3C/script%3E'));

$(document).ready(() => {
    Loading(true);

    let metodo = "metodoFuncionario";
    let valor = "Listar";
    let post = `${metodo}=${valor}`;

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
                let lista = dados.lista;

                let ordenacao = {
                    Id: {
                        id: "order-id",
                        atributo: "Id",
                        type: "numero"
                    },
                    Nome: {
                        id: "order-nome",
                        atributo: "Nome",
                        type: "string"
                    },
                    NivelAcesso: {
                        id: "order-nivelAcesso",
                        atributo: "NivelAcesso",
                        type: "numero"
                    }
                };

                AtualizarPagina(lista, ordenacao);

                HabilitarFiltro(lista, ordenacao);

                Loading(false);
            }
        },
        error: erro => {
            Loading(false);

            AcionarModalErro("Erro", erro.statusText, "bg-danger");
        }
    });

    let alerta = {
        mensagem: "Tem certeza que quer deletar este funcionario:",
        destaque: "nome" //Vai acessar o valor nome inclusso no botão de deletar
    };

    let controller = {
        controller: "../../Controllers/FuncionarioController.php", //Url para o controller
        metodo: "metodoFuncionario", //qual o tipo de metodo (metodo seguido do nome do controller)
        valor: "Deletar" //Nome do metodo que irá executar
    };

    HabilitarExclusao(alerta, controller);
});

//Gera a tabela de acordo om a pagina passada
function GerarTabela(listaCompleta, pagina) {
    let listaPaginada = listar(listaCompleta, pagina);

    $('tbody').html("");

    $.each(listaPaginada, (i, funcionario) => {
        let nivelAcesso = DefinirNivelAcesso(funcionario.NivelAcesso);

        let numeros = (parseInt(pagina) - 1) * 25 + (i + 1);

        let colunas = {
            numeros: numeros,
            Nome: funcionario.Nome,
            NivelAcesso: nivelAcesso
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
                value: `funcionario=${funcionario.Id}&usuario=${funcionario.UsuarioId}&nome=${funcionario.Nome}`,
                html: "Deletar"
            }
        };

        let linha = CriarLinhaTabela(colunas, actions);

        $('tbody').append(linha);
    });
}
