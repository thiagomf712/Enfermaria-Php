//Script para fazer validação de formularios
document.write(unescape('%3Cscript src="../../JavaScript/validate.min.js" type="text/javascript"%3E%3C/script%3E'));

//Script para definir as mensagens padrões da validação
document.write(unescape('%3Cscript src="../../JavaScript/validateMessage.js" type="text/javascript"%3E%3C/script%3E'));

//Script com funções gerais (loading)
document.write(unescape('%3Cscript src="../../JavaScript/Geral/geral.js" type="text/javascript"%3E%3C/script%3E'));


$(document).ready(() => {

    let loginSenha = {
        required: true,
        minlength: 4,
        maxlength: 20
    };

    $('form.needs-validation').validate({
        submitHandler: function (form) {
            $(form).trigger("Enviar");
        },
        onfocusout: function (element) {
            $(element).valid();
        },
        errorPlacement: function (error, element) {
            error.addClass("invalid-feedback");
            error.insertAfter(element);
        },
        errorClass: "is-invalid",
        validClass: "is-valid",

        rules: {
            login: loginSenha,
            senha: loginSenha
        }
    });

    //Evento chamado apos validar o submit
    $('form.needs-validation').on("Enviar", e => {

        let dados = $(e.target).serialize();

        $.ajax({
            type: 'POST',
            url: "../../Controllers/UsuarioController.php",
            data: dados,
            dataType: 'json',
            success: dados => {
                Loading(false);

                console.log(dados);

                if (dados.hasOwnProperty("erro")) {
                    AcionarModalErro("Erro", dados.erro, "bg-danger");
                } else {
                    window.location.href = "../Geral/Home.php";
                }
            },
            error: erro => {
                Loading(false);

                AcionarModalErro("Erro", erro.statusText, "bg-danger");
            }
        });
    });
});

