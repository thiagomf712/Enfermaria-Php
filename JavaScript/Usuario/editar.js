
//Script com funções gerais (loading)
document.write(unescape('%3Cscript src="../../JavaScript/Geral/geral.js" type="text/javascript"%3E%3C/script%3E'));

//Script para fazer validação de formularios
document.write(unescape('%3Cscript src="../../JavaScript/validate.min.js" type="text/javascript"%3E%3C/script%3E'));

//Script para definir as mensagens padrões da validação
document.write(unescape('%3Cscript src="../../JavaScript/validateMessage.js" type="text/javascript"%3E%3C/script%3E'));

//Script necessario para edição de formularios
document.write(unescape('%3Cscript src="../../JavaScript/Geral/editar.js" type="text/javascript"%3E%3C/script%3E'));


$(document).ready(() => {
    
    ValidarNivelAcesso(3);
    
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
            senha: {
                required: true,
                minlength: 4,
                maxlength: 20
            },
            confirmarSenha: {
                required: true,
                equalTo: "#senha"
            }
        },
        
        messages: {
            confirmarSenha: {
                equalTo: "As senhas devem ser iguais"
            }
        }
    });

    //Efetuar as alterações   
    let controller = {
        controller: "../../Controllers/UsuarioController.php", //Url para o controller
        metodo: "metodoUsuario", //qual o tipo de metodo (metodo seguido do nome do controller)
        valor: "AlterarSenha" //Nome do metodo que irá executar
    };
   
    EfetuarEdicao(controller);
});

//Verifica se os inputs de senha e confirmarSenha são iguais
function ValidarSenha(event) {
    let confirmar = $(event.target);
    let senha = $("#senha");

    let mensagem = VerificarSenhas(confirmar.val(), senha.val());

    AtribuirMensagem(mensagem, confirmar);
}

//Verifica se as duas strings são iguais
function VerificarSenhas(senha, confirmar) {
    if (senha !== confirmar) {
        return "As senhas não são iguais";
    } else {
        return false;
    }
}


