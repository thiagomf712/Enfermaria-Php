
//Validar o comprimento dos inputs (deve-se passar o seletor como parametro)
ValidarTamanhoInputs("#nome, #login, #senha");

//Validar a confirmação da senha
$('#confirmarSenha').on('blur', event => {

    ValidarSenha(event);

    $(event.target).on('keyup', event => {
        ValidarSenha(event);
    });
});

//Ao modificar a senha já verifica se o confirmar senha está igual
$('#senha').on('blur', () => $('#confirmarSenha').trigger("blur"));

//Verifica se todos os inputs passados são validos
ValidarSubmit("#nome, #login, #senha, #confirmarSenha");

//Evento chamado apos validar o submit
$('form.needs-validation').on("Enviar", e => {

    let dados = $(e.target).serialize();
    
    let metodo = "metodoFuncionario";
    let valor = "Cadastrar";
    
    dados += `&${metodo}=${valor}`;
    
    $.ajax({
        type: 'POST',
        url: "../../Controllers/FuncionarioController.php",
        data: dados,
        dataType: 'json',
        success: dados => {
            Loading(false);

            if (dados.erro !== "") {
                AcionarModalErro("Erro", dados.erro, "bg-danger");
            } else if (dados.sucesso !== "") {
                AcionarModalErro("Sucesso", dados.sucesso, "bg-success");         
                LimparForm(e.target);
            }
        },
        error: erro => {
            Loading(false);
            AcionarModalErro("Erro", erro.statusText, "bg-danger");
        }
    });
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