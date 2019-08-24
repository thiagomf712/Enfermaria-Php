
//Deve ser separado por uma virgula cada input
ValidarSubmit("#login, #senha");

$('form.needs-validation').on("Enviar", e => {

    let dados = $(e.target).serialize();
    $.ajax({
        type: 'POST',
        url: "../../Controllers/UsuarioController.php",
        data: dados,
        //dataType: 'json',
        success: data => {
            Loading(false);
            
            console.log(data);
            
            let dados = JSON.parse(data);

            if (dados.erro !== "") {
                $("#modal-titulo").html("Erro");
                $("#modal-conteudo").html(dados.erro);
                $("#modal").modal();
            } else {
                window.location.href = "../Geral/Home.php";
            }
        },
        error: erro => {
            Loading(false);

            $("#modal-titulo").html("Erro");
            $("#modal-conteudo").html(erro.statusText);
            $("#modal").modal();
        }
    });
});

