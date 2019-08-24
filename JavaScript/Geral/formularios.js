function ValidarSubmit(inputs) {

    ValidarInputs(inputs);

    $('form.needs-validation').on('submit', event => {
        event.preventDefault();

        Loading(true);

        let input = inputs.split(", ");
        let validado = true;

        //Varrendo todos os inputs necessarios 
        $.each(input, (indice, valor) => {
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

function ValidarInputs(inputs) {
    $(inputs).on('blur', event => {
        ValidarInput(event);

        $(event.target).on('keyup', event => {
            ValidarInput(event);
        });
    });
}

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

function ValidarInput(event) {
    let input = $(event.target);

    let mensagem = ValidarTamanho(input.val(), input.attr('minlength'));

    //Se retornar uma mensagem houve um erro na validação
    if (mensagem) {
        input.next().html(mensagem);

        TogleClassValid(input, false);

    } else {
        input.next().html('');

        TogleClassValid(input, true);
    }
}

function ValidarTamanho(valor, min) {
    if (valor.length === 0) {
        return "O campo deve ser preenchido";
    } else if (valor.length < min) {
        return "O campo deve conter no minimo " + min + " caracteres";
    } else {
        return false;
    }
}

//Ativa ou desativa o efeito de validação com base o estado passado(true - valido / false - invalido)
function TogleClassValid(input, estado) {
    if (estado) {
        input.removeClass('is-invalid');
        input.addClass('is-valid');
    } else {
        input.removeClass('is-valid');
        input.addClass('is-invalid');
    }
}




