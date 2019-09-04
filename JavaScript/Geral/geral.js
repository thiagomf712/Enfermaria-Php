
function ValidarNivelAcesso(nivelMinimo) {
    let nivelAtual = parseInt($('#nivelAcessoAtivo').val());
    
    if(nivelAtual < nivelMinimo) {
        location.href = "../Geral/Home.php";
    }
}


//Cria o loading e o adiciona no body caso esteja ligado, e o remove caso esteja desligado
function Loading(ligado) {
    let img = document.createElement('img');
    img.src = "../../img/loading.gif";
    img.className = "img-fluid";

    let div = document.createElement('div');
    div.id = "loading";
    div.className = "h-100 w-100 position-fixed d-flex justify-content-center align-items-center";
    div.style = "background-color: rgba(0, 0, 0, 0.7); z-index: 2; left:0; top:0";
    div.appendChild(img);

    if (ligado) {
        $('body').prepend(div);
    } else {
        $('#loading').remove();
    }
}

//Aciona o modal de resposta pasando um titulo, o conteudo do modal e a cor de fundo do titulo
function AcionarModalErro(titulo, dados, tituloBg) {

    if ($("#modal-titulo").parent().hasClass("bg-danger")) {
        $("#modal-titulo").parent().removeClass("bg-danger");
    } else if ($("#modal-titulo").parent().hasClass("bg-success")) {
        $("#modal-titulo").parent().removeClass("bg-success");
    }

    $("#modal-titulo").html(titulo);
    $("#modal-titulo").parent().addClass(tituloBg);
    $("#modal-conteudo").html(dados);
    $("#modal").modal();
}

//Converte parametros (url Get) em um objeto
function ParametroToObjetct(parametros) {
    let objeto = new Object();

    $.each(parametros.split("&"), (i, value) => {
        objeto[value.split("=")[0]] = decodeURIComponent(value.split("=")[1]);
    });

    return objeto;
}