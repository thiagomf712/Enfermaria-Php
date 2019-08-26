
//Verifica se todos os elemento passados possuem a class is-valid ao tentar dar submit
function ValidarSubmit(inputs) {
    $('form.needs-validation').on('submit', event => {
        event.preventDefault();

        Loading(true);

        let input = inputs.split(", ");
        let validado = true;

        //Varrendo todos os inputs necessarios 
        $.each(input, (i, valor) => {
            if (!$(valor).hasClass("is-valid")) {
                validado = false;
            }
        });

        if (!validado) {
            $(inputs).trigger('blur');

            Loading(false);
        } else {
            $('form.needs-validation').trigger("Enviar");
        }
    });
}

//Adiciona os eventos ao inputs passados e validar o tamanho
function ValidarTamanhoInputs(inputs) {
    $(inputs).on('blur', event => {
        ValidarTamanhoInput(event);

        $(event.target).on('keyup', event => {
            ValidarTamanhoInput(event);
        });
    });
}

//Só uma função para não ter que repetir codigo
function ValidarTamanhoInput(event) {
    let input = $(event.target);

    let mensagem = ValidarTamanho(input.val(), input.attr('minlength'));

    AtribuirMensagem(mensagem, input);
}

//Verifica se uma string tem mais caracteres que o minimo passado
function ValidarTamanho(valor, min) {
    if (valor.length === 0) {
        return "O campo deve ser preenchido";
    } else if (valor.length < min) {
        return "O campo deve conter no minimo " + min + " caracteres";
    } else {
        return false;
    }
}

//Cria um elemento proximo ao input e atribui uma mensagem a ele caso exista essa mensagem
//Se a mensage nao existir ele elimina o elemento da tela caso ele tenha sido criado
function AtribuirMensagem(mensagem, input) {
    let idDiv = `${input.attr("id")}Erro`;

    if (mensagem) {
        let div;

        if (document.getElementById(idDiv) === null) {
            div = document.createElement('div');
            div.id = idDiv;
            div.className = "invalid-feedback";

            input.after(div);
        } else {
            div = document.getElementById(idDiv);
        }

        div.innerHTML = mensagem;

        TogleClassValid(input, false);

    } else {
        $(`#${idDiv}`).remove();

        TogleClassValid(input, true);
    }
}

//Ativa ou desativa o efeito visual de validação com base o estado passado(true - valido / false - invalido)
function TogleClassValid(input, estado) {
    if (estado) {
        input.removeClass('is-invalid');
        input.addClass('is-valid');
    } else {
        input.removeClass('is-valid');
        input.addClass('is-invalid');
    }
}

//Limpa os campos e tira a class is-valid
function LimparForm(form) {
    
    form.reset();
    
    $("form.needs-validation input").each((i, valor) => {
        $(valor).removeClass("is-valid");
    });
}

//Cria o loading e o adiciona no body caso esteja ligado, e o remove caso esteja desligado
function Loading(ligado) {
    let img = document.createElement('img');
    img.src = "../../img/loading.gif";
    img.className = "img-fluid";

    let div = document.createElement('div');
    div.id = "loading";
    div.className = "h-100 w-100 position-fixed d-flex justify-content-center align-items-center";
    div.style = "background-color: rgba(0, 0, 0, 0.7); z-index: 2; left:0; top:0";
    div.appendChild(img);

    if (ligado) {
        $('body').prepend(div);
    } else {
        $('#loading').remove();
    }
}

//Aciona o modal de resposta pasando um titulo, o conteudo do modal e a cor de fundo do titulo
function AcionarModalErro(titulo, dados, tituloBg) {

    if ($("#modal-titulo").parent().hasClass("bg-danger")) {
        $("#modal-titulo").parent().removeClass("bg-danger");
    } else if ($("#modal-titulo").parent().hasClass("bg-success")) {
        $("#modal-titulo").parent().removeClass("bg-success");
    }

    $("#modal-titulo").html(titulo);
    $("#modal-titulo").parent().addClass(tituloBg);
    $("#modal-conteudo").html(dados);
    $("#modal").modal();
}


