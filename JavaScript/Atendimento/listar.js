
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
            id: "order-paciente",
            atributo: "Paciente",
            type: "string"
        },
        Data: {
            id: "order-data",
            atributo: "Data",
            type: "date"
        },
        Hora: {
            id: "order-hora",
            atributo: "Hora",
            type: "string"
        },
        Funcionario: {
            id: "order-funcionario",
            atributo: "Funcionario",
            type: "string"
        }
    };

    let controller = {
        controller: "../../Controllers/AtendimentoController.php", //Url para o controller
        metodo: "metodoAtendimento", //qual o tipo de metodo (metodo seguido do nome do controller)
        valor: "Listar" //Nome do metodo que irá executar
    };

    //o true está dizendo que vai ter um filtro entre duas datas
    GerarDadosTabela(ordenacao, controller, true);

    let alerta = {
        mensagem: "Tem certeza que quer deletar o atendimento do: ",
        destaque: "paciente" //Vai acessar o valor nome inclusso no botão de deletar
    };

    controller.valor = "Deletar";

    HabilitarExclusao(alerta, controller);
});

//Gera a tabela de acordo om a pagina passada
function GerarTabela(listaCompleta, pagina) {
    let listaPaginada = listar(listaCompleta, pagina);

    $('tbody').html("");

    $.each(listaPaginada, (i, atendimento) => {
        let numeros = (parseInt(pagina) - 1) * 25 + (i + 1);        
        
        let colunas = {
            numeros: numeros,
            Paciente: atendimento.Paciente,
            Data: FormatarData(atendimento.Data),
            Hora: FormatarHora(atendimento.Hora),
            Funcionario: atendimento.Funcionario
        };

        let actions = {
            detalhes: {
                type: 'a',
                href: `Detalhes.php?atendimento=${atendimento.Id}`,
                html: "Detalhes"
            },
            editar: {
                type: 'a',
                href: `Editar.php?atendimento=${atendimento.Id}`,
                html: "Editar"
            },
            deletar: {
                type: 'button',
                value: `atendimento=${atendimento.Id}&paciente=${atendimento.Paciente}`,
                html: "Deletar"
            }
        };

        let linha = CriarLinhaTabela(colunas, actions);

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

function FormatarHora(Hora) {
    let hora = Hora.split(":");
    let horas = hora[0];
    let minutos = hora[1];
    
    return `${horas}:${minutos}`;
}