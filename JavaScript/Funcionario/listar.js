
//Script com funções gerais (loading)
document.write(unescape('%3Cscript src="../../JavaScript/Geral/geral.js" type="text/javascript"%3E%3C/script%3E'));

//Script com funções gerais para listas
document.write(unescape('%3Cscript src="../../JavaScript/Geral/listas.js" type="text/javascript"%3E%3C/script%3E'));

$(document).ready(() => {

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

    let controller = {
        controller: "../../Controllers/FuncionarioController.php", //Url para o controller
        metodo: "metodoFuncionario", //qual o tipo de metodo (metodo seguido do nome do controller)
        valor: "Listar" //Nome do metodo que irá executar
    };

    GerarDadosTabela(ordenacao, controller);

    let alerta = {
        mensagem: "Tem certeza que quer deletar este funcionario:",
        destaque: "nome" //Vai acessar o valor nome inclusso no botão de deletar
    };

    controller.valor = "Deletar";

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
                html: "Detalhes",
                acesso: 4
            },
            editar: {
                type: 'a',
                href: `Editar.php?funcionario=${funcionario.Id}&usuario=${funcionario.UsuarioId}`,
                html: "Editar",
                acesso: 4
            },
            deletar: {
                type: 'button',
                value: `funcionario=${funcionario.Id}&usuario=${funcionario.UsuarioId}&nome=${funcionario.Nome}`,
                html: "Deletar",
                acesso: 4
            }
        };

        let linha = CriarLinhaTabela(colunas, actions, $('#nivelAcessoAtivo').val());

        $('tbody').append(linha);
    });
}
