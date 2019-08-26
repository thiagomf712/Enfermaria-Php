
//Validar o comprimento dos inputs
ValidarTamanhoInputs("#login, #senha");

//Verifica se todos os inputs passados são validos
ValidarSubmit("#login, #senha");

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
            
            if (dados.erro !== "") {
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

