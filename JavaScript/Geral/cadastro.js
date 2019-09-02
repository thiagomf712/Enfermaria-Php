//Limpa os campos e tira a class is-valid
function LimparForm(form) {

    form.reset();

    $("form.needs-validation input, form.needs-validation textarea, form.needs-validation select").each((i, valor) => {
        $(valor).removeClass("is-valid");
    });
}

//Efetua o cadastro depois da validção do submit
function EfetuarCadastro(controller) {
    $('form.needs-validation').on("Enviar", e => {
        Loading(true);

        let dados = $(e.target).serialize();

        let metodo = controller.metodo;
        let valor = controller.valor;

        dados += `&${metodo}=${valor}`;

        $.ajax({
            type: 'POST',
            url: controller.controller,
            data: dados,
            dataType: 'json',
            success: dados => {
                Loading(false);
                
                //console.log(dados);

                if (dados.hasOwnProperty("erro")) {
                    AcionarModalErro("Erro", dados.erro, "bg-danger");
                } else {
                    AcionarModalErro("Sucesso", dados.sucesso, "bg-success");
                    LimparForm(e.target);
                }
            },
            error: erro => {
                Loading(false);
                
                //console.log(erro);
                
                AcionarModalErro("Erro", erro.statusText, "bg-danger");
            }
        });
    });
}