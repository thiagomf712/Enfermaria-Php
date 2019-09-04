
//cria um div contendo a lista de sintomas e input de especificação e deletar(se quiser)
function CriarSintoma(numero, excluir, idSintoma = 0, idDb = 0) {
    Loading(true);

    //linha do sintoma
    let row = document.createElement('div');
    row.className = "form-row mb-3";

    //Select
    let divSelect = document.createElement('div');
    divSelect.className = "form-group col-md";

    //Label do select
    let labelSelect = document.createElement('label');
    labelSelect.setAttribute("for", `sintoma${numero}`);
    labelSelect.innerHTML = "Sintoma";

    //Lista de sintomas
    let select = document.createElement('select');
    select.className = "form-control";
    select.id = `sintoma${numero}`;
    select.name = `sintoma${numero}`;
    ListarSintomas(select, idSintoma);

    //juntando o grupo input com os inputs
    divSelect.appendChild(labelSelect);
    divSelect.appendChild(select);


    if (idDb !== 0) {
        let idHidden = document.createElement('input');
        idHidden.type = 'hidden';
        idHidden.id = `id${numero}`;
        idHidden.name = `id${numero}`;
        idHidden.value = idDb;
        
        divSelect.appendChild(idHidden);
    }


    //Especificação
    let divEspec = document.createElement('div');
    divEspec.className = "form-group col-md";

    //Label da especificação
    let labelEspec = document.createElement('label');
    labelEspec.setAttribute("for", `especificacao${numero}`);
    labelEspec.innerHTML = "Especificação";

    //Especificação
    let espec = document.createElement('input');
    espec.className = "form-control";
    espec.id = `especificacao${numero}`;
    espec.name = `especificacao${numero}`;
    espec.type = "text";
    espec.setAttribute("maxlength", 20);

    //juntando o grupo input com os inputs
    divEspec.appendChild(labelEspec);
    divEspec.appendChild(espec);

    //Juntando tudo na linha
    row.appendChild(divSelect);
    row.appendChild(divEspec);

    if (excluir) {
        //Remover
        let divRemove = document.createElement('div');
        divRemove.className = "form-group col-md-1 align-items-end d-flex";

        //Botão excluir
        let excluir = document.createElement('button');
        excluir.type = "button";
        excluir.className = "btn btn-danger btn-block";
        excluir.innerHTML = "x";
        excluir.style = "height: 45px";
        excluir.value = numero;

        divRemove.appendChild(excluir);

        //Juntando tudo na linha
        row.appendChild(divRemove);
    }

    $('#renderSintoma').append(row);

    Loading(false);
}

//Preenche o select com os sintomas cadastrados no sitema
function ListarSintomas(select, idSintoma = 0) {
    let controller = {
        controller: "../../Controllers/SintomaController.php", //Url para o controller
        metodo: "metodoSintoma", //qual o tipo de metodo (metodo seguido do nome do controller)
        valor: "Listar" //Nome do metodo que irá executar
    };

    let dados = `${controller.metodo}=${controller.valor}`;

    $.ajax({
        type: 'POST',
        url: controller.controller,
        data: dados,
        dataType: 'json',
        success: dados => {
            if (dados.hasOwnProperty("erro")) {
                Loading(false);

                AcionarModalErro("Erro", dados.erro, "bg-danger");
            } else {
                $.each(dados.lista, (i, valor) => {
                    let option = document.createElement('option');
                    option.value = valor.Id;
                    option.innerHTML = valor.Nome;

                    if (valor.Id === idSintoma) {
                        option.setAttribute("selected", "selected");
                    }

                    select.appendChild(option);
                });
            }
        },
        error: erro => {
            Loading(false);

            AcionarModalErro("Erro", erro.statusText, "bg-danger");
        }
    });
}

//Adiciona ou remove sintomas da tela ao se clicar nos botões
function AdicionarRemover(numeroSintomas) {
    //Adicionar Sintoma
    $('#adicionar').on('click', e => {

        let adicionarNovo = true;

        $.each(numeroSintomas, (i, valor) => {
            if (valor === 'desocupado') {
                adicionarNovo = false;
                CriarSintoma(i + 1, true);
                numeroSintomas[i] = "ocupado";
                return false;
            }
        });

        if (adicionarNovo) {
            numeroSintomas.push("ocupado");
            CriarSintoma(numeroSintomas.length, true);
        }
    });

    //Remover sintomas
    $('#renderSintoma').on('click', 'button', e => {
        $(e.target).parent().parent().remove();
        numeroSintomas[$(e.target).val() - 1] = "desocupado";
    });
}

//Lista todos os funcionarios no select e já deixa selecionado o funcionario que está logado
//Se o funcionario for false o id recebido foi o usuarioId
//Se o funcionario for true o id recebido foi o id do funcionario
function ListarFuncionarios(select, id, funcionario = false) {
    Loading(true);

    let controller = {
        controller: "../../Controllers/FuncionarioController.php", //Url para o controller
        metodo: "metodoFuncionario", //qual o tipo de metodo (metodo seguido do nome do controller)
        valor: "ListarNomes" //Nome do metodo que irá executar
    };

    let dados = `${controller.metodo}=${controller.valor}`;

    $.ajax({
        type: 'POST',
        url: controller.controller,
        data: dados,
        dataType: 'json',
        success: dados => {
            if (dados.hasOwnProperty("erro")) {
                Loading(false);

                AcionarModalErro("Erro", dados.erro, "bg-danger");
            } else {
                $.each(dados.lista, (i, valor) => {
                    let option = document.createElement('option');
                    option.value = valor.Id;
                    option.innerHTML = valor.Nome;

                    if ((!funcionario && id === valor.UsuarioId) || (funcionario && id === valor.Id)) {
                        option.setAttribute("selected", "selected");
                    }

                    //O select é um objeto jquery
                    select.append(option);

                    Loading(false);
                });
            }
        },
        error: erro => {
            Loading(false);

            AcionarModalErro("Erro", erro.statusText, "bg-danger");
        }
    });
}

function DadosPaciente() {
    let paciente = ParametroToObjetct(location.search.slice(1));

    $('#nome').val(paciente.nome);
    $('#ra').val(paciente.ra);
}

