
//Script com funções gerais (loading)
document.write(unescape('%3Cscript src="../../JavaScript/Geral/geral.js" type="text/javascript"%3E%3C/script%3E'));

//Script necessario para validação de formularios
document.write(unescape('%3Cscript src="../../JavaScript/Geral/formularios.js" type="text/javascript"%3E%3C/script%3E'));


$(document).ready(() => {
    Loading(true);

    let metodo = "metodoFuncionario";
    let valor = "GetFuncionario";
    let post = `${metodo}=${valor}&${location.search.slice(1)}`;

    //Recuperar o funcionario e preencher os campos
    $.ajax({
        type: 'POST',
        url: "../../Controllers/FuncionarioController.php",
        data: post,
        dataType: 'json',
        success: dados => {
            if (dados.hasOwnProperty("erro")) {
                Loading(false);
                AcionarModalErro("Erro", dados.erro, "bg-danger");
            } else {
                //Preencher o form com os dados
                let funcionario = dados.resultado;

                $('#nome').val(funcionario.nome);
                $('#login').val(funcionario.usuario.login);
                $('#nivelAcesso').val(funcionario.usuario.nivelAcesso);

                Loading(false);
            }
        },
        error: erro => {
            Loading(false);

            AcionarModalErro("Erro", erro.statusText, "bg-danger");
        }
    });

    //Validar alterações
    ValidarTamanhoInputs("#nome, #login");

    //Validar submit
    ValidarSubmit("#nome, #login");

    //Efetuar as alterações
    $('form.needs-validation').on("Enviar", e => {

        let dados = $(e.target).serialize();

        let metodo = "metodoFuncionario";
        let valor = "Editar";
        let post = `${dados}&${metodo}=${valor}&${location.search.slice(1)}`;

        $.ajax({
            type: 'POST',
            url: "../../Controllers/FuncionarioController.php",
            data: post,
            dataType: 'json',
            success: dados => {
                Loading(false);

                if (dados.hasOwnProperty("erro")) {
                    AcionarModalErro("Erro", dados.erro, "bg-danger");
                } else {
                    AcionarModalErro("Sucesso", dados.sucesso, "bg-success");

                    $('#modal').on('hidden.bs.modal', () => {
                        window.location.href = "Listar.php";
                    });
                }
            },
            error: erro => {
                Loading(false);
                AcionarModalErro("Erro", erro.statusText, "bg-danger");
            }
        });
    });
});