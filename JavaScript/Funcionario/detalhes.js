
//Script com funções gerais (loading)
document.write(unescape('%3Cscript src="../../JavaScript/Geral/geral.js" type="text/javascript"%3E%3C/script%3E'));

$(document).ready(() => {
    
    ValidarNivelAcesso(4);
    
    Loading(true);

    let metodo = "metodoFuncionario";
    let valor = "GetFuncionario";
    let post = `${metodo}=${valor}&${location.search.slice(1)}`;
    
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
});