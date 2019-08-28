
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

//Gera as opções de pagina do select de paginas
function GerarPaginacao(numeroPaginas) {
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
    let max = (paginaAtual * 25 - 1 > lista.length) ? (lista.length - 1) : (paginaAtual * 25 - 1);

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

//Adiciona o evento de clicks para as setas
function HabilitarAlteracaoPaginaSetas() {
    $('#proxima').on('click', () => {
        let paginacao = $('#pagina');

        paginacao.val(parseInt(paginacao.val()) + 1).trigger('change');
    });

    $('#anterior').on('click', () => {
        let paginacao = $('#pagina');

        paginacao.val(parseInt(paginacao.val()) - 1).trigger('change');
    });
}

function HabilitarAlteracaoPaginaSelect(lista, numeroPaginas) {
    $('#pagina').on("change", e => {
        let paginaAtual = $(e.target).val();

        GerarTabela(lista, paginaAtual);

        $('html, body').scrollTop(0);

        //Reatualiza quais setas estão disponiveis
        HabilitarSetas(numeroPaginas);
    });
}


//Recebe um objeto contendo os itens que serão ordenados
//Cada item deve informar: 
//(id: id do botão a ser alterado)
//(atributo: qual o atributo dentro da lista que será alterado)
//(type: qual o tipo de dado que será filtrado (string ou numero)
function Ordenar(lista, ordenacao) {

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

            $('#pagina').val(1).trigger("change");
        });
    });
}