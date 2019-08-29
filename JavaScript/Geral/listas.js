
/*------------------------------------------------------------------------------
 Funções relacionadas a Criação da tabela
 ------------------------------------------------------------------------------*/

//Espera dois objetos literais
//O primeiro objeto passa o conteudo de cada coluna (que vai ser exibido)
//O segundo objeto passa qual das 3 ações (detalhes, editar, deletar) vai ter e os dados de cada uma delas:
//(type: o tipo de elemento que vai ser a ação (button ou a))
//(href: No caso de <a> ele espera qual é o link para ele)
//(value: No caso de <button> ele espera qual o valor que esse button terá)
//(html: Qual vai ser o conteudo visivel desse action)
//Retorna a linha da tabela
function CriarLinhaTabela(colunas, action) {
    let tr = document.createElement('tr');
    tr.className = "table-light";

    $.each(colunas, (i, valor) => {
        let td = document.createElement('td');
        td.innerHTML = valor;
        tr.appendChild(td);
    });

    //Criar ações
    let tdAction = document.createElement('td');

    $.each(action, (i, valor) => {
        let action = document.createElement(valor.type);
        action.innerHTML = valor.html;
        action.className = "btn btn-primary btn-sm mb-1 mr-1";

        switch (i) {
            case "detalhes":
            case "editar":
                action.href = valor.href;
                break;
            case "deletar":
                action.type = "button";
                action.value = valor.value;
                action.className = "btn btn-primary btn-sm mb-1";
                break;
        }

        tdAction.appendChild(action);
    });

    tr.appendChild(tdAction);

    return tr;
}

//Retorna o nivel de acesso escrito.
function DefinirNivelAcesso(nivelAcesso) {
    let texto;

    switch (parseInt(nivelAcesso)) {
        case 1:
            texto = "Vizualizar";
            break;
        case 2:
            texto = "Adicionar";
            break;
        case 3:
            texto = "Editar / Remover";
            break;
        case 4:
            texto = "Master";
            break;
    }

    return texto;
}


/*------------------------------------------------------------------------------
 Funções relacionadas a atualização de conteudo
 ------------------------------------------------------------------------------*/

//Essa função só pode ser chamada em algum local que possua o metodo GerarTabela
//Ele faz todas as atualizações necessarias para ordenar, navegar entre as paginas e visualizar a tabela
function AtualizarPagina(lista, ordenacao) {
    //Define o numero de paginas
    numeroPaginas = Math.ceil(lista.length / 25);

    $('#quantidade').html(lista.length);

    //Gera a tabela
    GerarTabela(lista, 1);

    //Gera a paginação
    GerarPaginacao(numeroPaginas);

    //Habilita as setas para alterar a pagina
    HabilitarAlteracaoPaginaSetas();

    //Habilita o select para alterar a pagina
    HabilitarAlteracaoPaginaSelect(lista, numeroPaginas);

    //Habilita a filtragem dos elementos
    Ordenar(lista, ordenacao, numeroPaginas);
}

/*------------------------------------------------------------------------------
 Funções relacionadas a paginação do conteudo
 ------------------------------------------------------------------------------*/

//Gera as opções de pagina do select de paginas
function GerarPaginacao(numeroPaginas) {
    $('#pagina').html("");

    for (var i = 1; i <= numeroPaginas; i++) {
        let option = document.createElement("option");
        option.value = i;
        option.innerHTML = `Página ${i}`;

        $('#pagina').append(option);
    }

    HabilitarSetas(numeroPaginas);
}

//Transforma a lista completa que voltou do banco de dados e diminui ela para o tamanho da pagina (25 itens)
function listar(lista, paginaAtual) {
    let min = paginaAtual * 25 - 25;
    let max = (paginaAtual * 25 - 1 >= lista.length) ? (lista.length - 1) : (paginaAtual * 25 - 1);

    let listaPaginada = new Array();

    for (let i = min; i <= max; i++) {
        listaPaginada.push(lista[i]);
    }

    return listaPaginada;
}

//Habilita ou desabilita as setas para ir para a proxima pagina ou pagia anterior
function HabilitarSetas(numeroPaginas) {
    let paginaAtual = $('#pagina').val();

    if (paginaAtual < numeroPaginas) {
        $('#proxima').removeAttr('disabled');
    } else {
        $('#proxima').attr('disabled', 'disabled');
    }

    if (paginaAtual > 1) {
        $('#anterior').removeAttr('disabled');
    } else {
        $('#anterior').attr('disabled', 'disabled');
    }
}

//Adiciona o evento de clicks para as setas (chama o select)
function HabilitarAlteracaoPaginaSetas() {
    $('#proxima, #anterior').off('click');

    $('#proxima').on('click', () => {
        let paginacao = $('#pagina');

        paginacao.val(parseInt(paginacao.val()) + 1).trigger('change');
    });

    $('#anterior').on('click', () => {
        let paginacao = $('#pagina');

        paginacao.val(parseInt(paginacao.val()) - 1).trigger('change');
    });
}

//Adiciona o evento para alterar visualmente a pagina da tabela
function HabilitarAlteracaoPaginaSelect(lista, numeroPaginas) {
    //Comando para não ficar adiconando o evento varias vezes quando filtra a lista
    $('#pagina').off("change");

    $('#pagina').on("change", e => {
        let paginaAtual = $(e.target).val();

        GerarTabela(lista, paginaAtual);

        $('html, body').scrollTop(0);

        //Reatualiza quais setas estão disponiveis
        HabilitarSetas(numeroPaginas);
    });
}


/*------------------------------------------------------------------------------
 Funções relacionadas a Ordenação da tabela
 ------------------------------------------------------------------------------*/

//Recebe um objeto contendo os itens que serão ordenados
//Cada item deve informar: 
//(id: id do botão a ser alterado)
//(atributo: qual o atributo dentro da lista que será alterado)
//(type: qual o tipo de dado que será filtrado (string ou numero)
function Ordenar(lista, ordenacao, numeroPaginas) {
    //Correção de um bug devido a filtragem da lista (Duplicar eventos a cada filtragem)
    $('th button').off("click");

    //Remover ordenado de um botão caso outro seja clicado
    $('th button').on("click", (e) => {
        $('th button').each((i, value) => {
            if (e.target !== value) {
                $(value).val("");
            }
        });
    });

    //Adicionar a ordenação em cada um dos botões
    $.each(ordenacao, (i, valor) => {
        $(`#${valor.id}`).on("click", e => {
            if ($(e.target).val() === "ordenado") {
                lista.reverse();

                $(e.target).val("");
            } else {
                lista.sort((a, b) => {
                    let pri = a[valor.atributo];
                    let sec = b[valor.atributo];

                    if (valor.type === "numero") {
                        pri = parseInt(pri);
                        sec = parseInt(sec);
                    } else if (valor.type === "string") {
                        pri = pri.toLowerCase();
                        sec = sec.toLowerCase();
                    }

                    if (pri < sec) {
                        return -1;
                    }

                    if (pri > sec) {
                        return 1;
                    }

                    return 0;
                });

                $(e.target).val("ordenado");
            }

            $('#pagina').val(1);
            
            GerarTabela(lista, 1);
            
            HabilitarSetas(numeroPaginas);
        });
    });
}


/*------------------------------------------------------------------------------
 Funções relacionadas ao filtro
 ------------------------------------------------------------------------------*/

//Habilita a filtragem de dados nas tabelas
function HabilitarFiltro(lista, ordenacao) {
    //Filtro
    $('form#filtro').on("submit", e => {
        e.preventDefault();

        let filtros = $(e.target).serializeArray();

        //Filtrando lista
        let listaFiltrada = FiltrarArray(lista, filtros);

        //Atualizando os comportamentos da lista baseado na nova lista filtrada
        AtualizarPagina(listaFiltrada, ordenacao);
    });

    HabilitarRemoverFiltros();
}

//Habilita a remoção dos filtros
function HabilitarRemoverFiltros() {
    $('#remover').on("click", () => {
        document.getElementById("filtro").reset();
        $('form#filtro').trigger("submit");
    });
}

//Filtra uma array de acordo com o filtro passado
//Como filtro se espera uma array com chaves -> valor representando qual o atributo da lista a ser filtrado e o valor que deve conter
function FiltrarArray(lista, filtros) {
    let listaFiltrada = lista.filter((valor) => {
        let filtro = true;
        let teste;

        for (var i = 0; i < filtros.length; i++) {
            teste = valor[filtros[i].name].toLowerCase().indexOf(filtros[i].value.toLowerCase()) > -1;

            filtro = filtro && teste;
        }

        return filtro;
    });

    return listaFiltrada;
}


/*------------------------------------------------------------------------------
 Funções relacionadas a deletar dados
 ------------------------------------------------------------------------------*/

//Converte parametros (url Get) em um objeto
function ParametroToObjetct(parametros) {
    let objeto = new Object();

    $.each(parametros.split("&"), (i, value) => {
        objeto[value.split("=")[0]] = value.split("=")[1];
    });

    return objeto;
}

//Habilita a exclusão de dados
//alerta = é o que vai aparecer no alerta antes de deletar (objeto com atributos -> mensagem, destaque)
//controller = para onde será mandado a requisição de deletar (objeto com atributos -> controller (url), metodo, valor (metodo que será executado)
function HabilitarExclusao(alerta, controller) {
    
    //Aciona um modal de alerta ao clicar em deletar na lista
    $("tbody").on('click', "td button", e => {
        let params = $(e.target).val();

        //Transformar o valor passado em um objeto
        let objeto = ParametroToObjetct(params);

        //Mostrar Modal de alerta
        let conteudo = document.createElement('div');
        conteudo.innerHTML = alerta.mensagem;

        if (alerta.hasOwnProperty('destaque')) {
            let destaque = document.createElement('div');
            destaque.className = "font-weight-bold w-100 text-center mt-2";
            destaque.innerHTML = objeto[alerta.destaque];

            conteudo.appendChild(destaque);
        }

        $('#alerta-conteudo').html(conteudo);
        $('#alerta').modal();
        $('#alerta-deletar').val(params);
    });
    
    //Faz a exclusão dos dados ao clicar no botão de deletar do modal
    $('#alerta-deletar').on('click', e => {
        $('#alerta').modal('hide');

        Loading(true);

        let params = $(e.target).val();

        //Deletar funcionario
        let metodo = controller.metodo;
        let valor = controller.valor;
        let post = `${metodo}=${valor}&${params}`;

        $.ajax({
            type: 'POST',
            url: controller.controller, 
            data: post,
            dataType: 'json',
            success: dados => {
                Loading(false);

                if (dados.hasOwnProperty("erro")) {
                    AcionarModalErro("Erro", dados.erro, "bg-danger");
                } else {
                    AcionarModalErro("Sucesso", dados.sucesso, "bg-success");

                    $('#modal').on('hidden.bs.modal', () => {
                        window.location.reload();
                    });
                }
            },
            error: erro => {
                Loading(false);
                AcionarModalErro("Erro", erro.statusText, "bg-danger");
            }
        });
    });
}