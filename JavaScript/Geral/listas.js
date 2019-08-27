
//Espera dois objetos literais
//O primeiro objeto passa o conteudo de cada coluna
//O segundo objeto passa qual das 3 ações (detalhes, editar, deletar) vai ter e os dados de cada uma delas
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
function HabilitarAlteracaoPagina() {
    $('#proxima').on('click', () => {
        let paginacao = $('#pagina');

        paginacao.val(parseInt(paginacao.val()) + 1).trigger('change');
    });

    $('#anterior').on('click', () => {
        let paginacao = $('#pagina');

        paginacao.val(parseInt(paginacao.val()) - 1).trigger('change');
    });
}