
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
        Ra: {
            id: "order-ra",
            atributo: "Ra",
            type: "numero"
        },
        Regime: {
            id: "order-regime",
            atributo: "Regime",
            type: "numero"
        }
    };

    let controller = {
        controller: "../../Controllers/PacienteController.php", //Url para o controller
        metodo: "metodoPaciente", //qual o tipo de metodo (metodo seguido do nome do controller)
        valor: "Listar" //Nome do metodo que irá executar
    };

    GerarDadosTabela(ordenacao, controller);
});

//Gera a tabela de acordo om a pagina passada
function GerarTabela(listaCompleta, pagina) {
    let listaPaginada = listar(listaCompleta, pagina);

    $('tbody').html("");

    $.each(listaPaginada, (i, paciente) => {
        let regime = DefinirRegime(paciente.Regime);

        let numeros = (parseInt(pagina) - 1) * 25 + (i + 1);

        let colunas = {
            numeros: numeros,
            Nome: paciente.Nome,
            Ra: paciente.Ra,
            Regime: regime
        };

        let actions = {
            detalhes: {
                type: 'a',
                href: `Cadastrar.php?paciente=${paciente.Id}&nome=${paciente.Nome}&ra=${paciente.Ra}`,
                html: "Adicionar novo atendimento",
                acesso: 2
            },
            editar: {
                type: 'a',
                href: `FichaMedica.php?ficha=${paciente.FichamedicaId}&nome=${paciente.Nome}&ra=${paciente.Ra}`,
                html: "Ficha médica",
                acesso: 2
            }
        };

        let linha = CriarLinhaTabela(colunas, actions,  $('#nivelAcessoAtivo').val());

        $('tbody').append(linha);
    });
}



