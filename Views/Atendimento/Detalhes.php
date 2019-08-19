<?php
define('__ROOT__', dirname(__FILE__, 3));
require_once(__ROOT__ . '/Models/Usuario.php');

require_once(__ROOT__ . '/Controllers/AtendimentoController.php');
require_once(__ROOT__ . '/Controllers/FuncionarioController.php');
require_once(__ROOT__ . '/Controllers/SintomaController.php');


if (session_id() == '') {
    session_start();
}

$id = isset($_GET['atendimento']) ? $_GET['atendimento'] : 0;

$atendimentos = AtendimentoController::RetornarAtendimento($id);

$funcionarios = FuncionarioController::RetornarNomeFuncionarios();

$_SESSION['sintomasCarregados'] = serialize($atendimentos['sintomas']);

if (!(isset($_SESSION['sintomas']))) {
    $_SESSION['sintomas'] = 0;
}

if (!(isset($_SESSION['listaSintomas']))) {
    $_SESSION['listaSintomas'] = serialize(SintomaController::RetornarNomesSintomas());
}

if (!isset($_SESSION['usuario'])) {
    header("Location: ../Usuario/Login.php");
}

$usuario = unserialize($_SESSION['usuario']);
?>

<!DOCTYPE html>
<html>
    <head lang="pt-br">
        <!-- Required meta tags -->
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css?version=2">

        <!-- Font Awesome -->
        <link rel="stylesheet" href="../../fontawesome/css/all.min.css">

        <!-- Estilo persinalizado -->
        <link rel="stylesheet" href="../../Css/estilo.css?version=12">

        <!-- JQuery -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>

        <title>Detalhes - Atendimento</title>
    </head>
    <body>

        <!-- Barra de navegação -->
        <?php include_once '../Compartilhado/Navbar.php'; ?>    

        <!-- Area da lista -->
        <div id="area-principal" class="container bg-primary">
            <div class="col-md-10 offset-md-1">
                <form>

                    <!-- Informações do paciente -->
                    <fieldset disabled>
                        <legend class="mb-4">Informações do paciente</legend>

                        <div class="form-row">

                            <!-- Nome -->
                            <div class="form-group col-md">
                                <label>Nome</label>
                                <input type="text" class="form-control" value="<?php echo $atendimentos['paciente']['Nome']; ?>"/>
                            </div>

                            <!-- Ra -->
                            <div class="form-group col-md">
                                <label>Ra</label>
                                <input type="number" class="form-control" value="<?php echo $atendimentos['paciente']['Ra']; ?>"/>
                            </div>
                        </div>
                    </fieldset>

                    <!-- Informações Atendimento -->
                    <fieldset class="mt-4" disabled>
                        <legend class="mb-4">Informações do atendimento</legend>

                        <div class="form-row">

                            <!-- Atendente -->
                            <div class="form-group col-md-5 col-lg-7">
                                <label>Atendente</label>
                                <select class="form-control">
                                    <?php for ($i = 0; $i < count($funcionarios); $i++) : ?>
                                        <option value="<?php echo $funcionarios[$i]['Id'] ?>" <?php echo ($atendimentos['atendimento']->getFuncionario() == $funcionarios[$i]['Id']) ? 'selected' : '' ?>><?php echo $funcionarios[$i]['Nome'] ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>

                            <!-- Hora -->
                            <div class="form-group col-md-3 col-lg-2">	
                                <label>Hora</label>
                                <input class="form-control" type="time" value="<?php echo $atendimentos['atendimento']->getHora(); ?>"/>
                            </div>

                            <!-- Data -->
                            <div class="form-group col-md-4 col-lg-3">	
                                <label>Data</label>
                                <input class="form-control" type="date" value="<?php echo $atendimentos['atendimento']->getData(); ?>"/>
                            </div>			
                        </div>
                    </fieldset>

                    <!-- Sintomas -->
                    <fieldset disabled>
                        <legend class="mb-4">Sintomas e Sinais</legend>

                        <input type="hidden" name="numeroSintomas" id="numeroSintomas" value="<?php echo count($atendimentos['sintomas']); ?>"/>

                        <!-- Lista de sintomas -->
                        <div id="renderSintoma">

                        </div>
                    </fieldset>

                    <!-- procedimento -->
                    <fieldset disabled>
                        <legend class="mb-4">Procedimento</legend>

                        <!-- Procedimento -->
                        <div class="form-group">
                            <label>Procedimento realizado</label>
                            <textarea class="form-control"><?php echo $atendimentos['atendimento']->getProcedimento(); ?></textarea>
                        </div>

                    </fieldset>

                    <!-- Botões -->
                    <div class="form- mt-4">
                        <button type="button" name="desabilitar" class="btn btn-secondary btn-block" onclick="history.go(-1);">Voltar</button>
                    </div>

                </form>
            </div>
        </div>  

        <!-- Rodapé -->    
        <?php include_once '../Compartilhado/Footer.php'; ?>

        <!-- Janela que aparece ao acontecer um erro no Backend (Precisa ser inserido depois do Jquery) -->
        <?php include_once '../Compartilhado/ModalErroSucesso.php'; ?> 

        <script src="../../JavaScript/jquery-3.4.1.js"></script>
        <script>
                            var renderSintoma = document.getElementById('renderSintoma');
                            var desabilitar = document.getElementsByName('desabilitar');

                            desabilitar[0].addEventListener("click", DesabilitarSintomas);

                            window.addEventListener("load", Carregar);

                            var inputContador = document.getElementById('numeroSintomas');
                            var contadorSintomas = inputContador.value;

                            function Carregar() {
                                for (var i = 0; i < inputContador.value; i++) {
                                    $.post('Auxiliar.php', {function: 'CarregarSintoma', varios: 'sim', index: i}, function (data) {
                                        var divNova = document.createElement("div");

                                        divNova.innerHTML = JSON.parse(data);
                                        renderSintoma.appendChild(divNova);
                                    });
                                }
                            }

                            function DesabilitarSintomas() {
                                $.post('Auxiliar.php', {function: 'DesabilitarSintomas'}, function () {
                                });
                            }
        </script>

        <script src="../../bootstrap/js/bootstrap.min.js"></script>
        <script src="../../JavaScript/Geral/bootstrapValidation.js"></script>     
    </body>
</html>



