//Script necessario para validação de formularios
document.write(unescape('%3Cscript src="../../JavaScript/Geral/formularios.js" type="text/javascript"%3E%3C/script%3E'));

//Script com funções gerais (loading)
document.write(unescape('%3Cscript src="../../JavaScript/Geral/geral.js" type="text/javascript"%3E%3C/script%3E'));


$(document).ready(() => {
    //Validar o comprimento dos inputs (deve-se passar o seletor como parametro)
    ValidarTamanhoInputs("#nome");

    //Verifica se todos os inputs passados são validos
    ValidarSubmit("#nome");

    let controller = {
        controller: "../../Controllers/SintomaController.php", //Url para o controller
        metodo: "metodoSintoma", //qual o tipo de metodo (metodo seguido do nome do controller)
        valor: "Cadastrar" //Nome do metodo que irá executar
    };
    
    EfetuarCadastro(controller);
});



