
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
        }
    };

    let controller = {
        controller: "../../Controllers/SintomaController.php", //Url para o controller
        metodo: "metodoSintoma", //qual o tipo de metodo (metodo seguido do nome do controller)
        valor: "Listar" //Nome do metodo que irá executar
    };

    GerarDadosTabela(ordenacao, controller);

    let alerta = {
        mensagem: "Tem certeza que quer deletar este sintoma:",
        destaque: "nome" //Vai acessar o valor nome inclusso no botão de deletar
    };

    controller.valor = "Deletar";

    HabilitarExclusao(alerta, controller);
});

//Gera a tabela de acordo om a pagina passada
function GerarTabela(listaCompleta, pagina) {
    let listaPaginada = listar(listaCompleta, pagina);

    $('tbody').html("");

    $.each(listaPaginada, (i, sintoma) => {
        let numeros = (parseInt(pagina) - 1) * 25 + (i + 1);

        let colunas = {
            numeros: numeros,
            Nome: sintoma.Nome
        };

        let actions = {
            editar: {
                type: 'a',
                href: `Editar.php?sintoma=${sintoma.Id}`,
                html: "Editar"
            },
            deletar: {
                type: 'button',
                value: `sintoma=${sintoma.Id}&nome=${sintoma.Nome}`,
                html: "Deletar"
            }
        };

        let linha = CriarLinhaTabela(colunas, actions);

        $('tbody').append(linha);
    });
}



