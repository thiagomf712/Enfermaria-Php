
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
            id: "order-login",
            atributo: "Login",
            type: "string"
        },
        NivelAcesso: {
            id: "order-nivelAcesso",
            atributo: "NivelAcesso",
            type: "numero"
        }
    };

    let controller = {
        controller: "../../Controllers/UsuarioController.php", //Url para o controller
        metodo: "metodoUsuario", //qual o tipo de metodo (metodo seguido do nome do controller)
        valor: "Listar" //Nome do metodo que irá executar
    };
    
    GerarDadosTabela(ordenacao, controller);   
});

//Gera a tabela de acordo om a pagina passada
function GerarTabela(listaCompleta, pagina) {
    let listaPaginada = listar(listaCompleta, pagina);

    $('tbody').html("");

    $.each(listaPaginada, (i, usuario) => {
        let nivelAcesso = DefinirNivelAcesso(usuario.NivelAcesso);

        let numeros = (parseInt(pagina) - 1) * 25 + (i + 1);

        let colunas = {
            numeros: numeros,
            Nome: usuario.Login,
            NivelAcesso: nivelAcesso
        };

        let actions = {
            editar: {
                type: 'a',
                href: `Editar.php?usuario=${usuario.Id}`,
                html: "Alterar Senha",
                acesso: 3
            }
        };

        let linha = CriarLinhaTabela(colunas, actions, $('#nivelAcessoAtivo').val());

        $('tbody').append(linha);
    });
}


