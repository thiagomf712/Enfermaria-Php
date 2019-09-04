
//Script com funções gerais (loading)
document.write(unescape('%3Cscript src="../../JavaScript/Geral/geral.js" type="text/javascript"%3E%3C/script%3E'));

//Script necessario para edição de formularios
document.write(unescape('%3Cscript src="../../JavaScript/Geral/editar.js" type="text/javascript"%3E%3C/script%3E'));

//Script para fazer validação de formularios
document.write(unescape('%3Cscript src="../../JavaScript/validate.min.js" type="text/javascript"%3E%3C/script%3E'));

//Script para definir as mensagens padrões da validação
document.write(unescape('%3Cscript src="../../JavaScript/validateMessage.js" type="text/javascript"%3E%3C/script%3E'));



$(document).ready(() => {
    Loading(true);

    let metodo = "metodoSintoma";
    let valor = "GetSintoma";
    let post = `${metodo}=${valor}&${location.search.slice(1)}`;

    //Recuperar o funcionario e preencher os campos
    $.ajax({
        type: 'POST',
        url: "../../Controllers/SintomaController.php",
        data: post,
        dataType: 'json',
        success: dados => {         
            if (dados.hasOwnProperty("erro")) {
                Loading(false);
                AcionarModalErro("Erro", dados.erro, "bg-danger");
            } else {
                //Preencher o form com os dados
                let sintoma = dados.resultado;

                $('#nome').val(sintoma.nome);

                Loading(false);
            }
        },
        error: erro => {
            Loading(false);
            
            AcionarModalErro("Erro", erro.statusText, "bg-danger");
        }
    });

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
            nome: {
                required: true,
                minlength: 3,
                maxlength: 50
            }
        }
    });

    //Efetuar as alterações
    let controller = {
        controller: "../../Controllers/SintomaController.php", //Url para o controller
        metodo: "metodoSintoma", //qual o tipo de metodo (metodo seguido do nome do controller)
        valor: "Editar" //Nome do metodo que irá executar
    };
    
    EfetuarEdicao(controller);
});