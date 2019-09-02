

function EfetuarEdicao(controller) {
     $('form.needs-validation').on("Enviar", e => {

        let dados = $(e.target).serialize();

        let metodo = controller.metodo;
        let valor = controller.valor;
        let post = `${dados}&${metodo}=${valor}&${location.search.slice(1)}`;

        $.ajax({
            type: 'POST',
            url: controller.controller,
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
}
