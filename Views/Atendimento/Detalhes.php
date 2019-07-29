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

$usuario = unserialize($_SESSION['usuario']);
?>

<!DOCTYPE html>
<html>
    <head lang="pt-br">
        <title>Detalhes - Atendimento</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta charset="UTF-8">

        <link rel="stylesheet" href="../../Css/forms.css" /> 
        <link rel="stylesheet" href="../../Css/bootstrap.css" />   
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>    

    </head>
    <body>
        <?php include_once '../Compartilhado/Navbar.php'; ?>    

        <div class="mx-auto p-4 formGeral form-grande">
            <form>
                <fieldset disabled>
                    <legend class="mb-4">Informações do paciente</legend>

                    <div class="form-row">
                        <div class="form-group col-md">
                            <label>Nome</label>
                            <input type="text" class="form-control" value="<?php echo $atendimentos['paciente']['Nome']; ?>"/>
                        </div>

                        <div class="form-group col-md">
                            <label>Ra</label>
                            <input type="number" class="form-control" value="<?php echo $atendimentos['paciente']['Ra']; ?>"/>
                        </div>
                    </div>
                </fieldset>
                <fieldset class="mt-4" disabled>
                    <legend class="mb-4">Informações do atendimento</legend>

                    <div class="form-row">
                        <div class="form-group col-md-7">
                            <label>Atendente</label>
                            <select class="form-control">
                                <?php for ($i = 0; $i < count($funcionarios); $i++) : ?>
                                    <option value="<?php echo $funcionarios[$i]['Id'] ?>" <?php echo ($atendimentos['atendimento']->getFuncionario() == $funcionarios[$i]['Id']) ? 'selected' : '' ?>><?php echo $funcionarios[$i]['Nome'] ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>

                        <div class="form-group col-md-2">	
                            <label>Hora</label>
                            <input class="form-control" type="time" value="<?php echo $atendimentos['atendimento']->getHora(); ?>"/>
                        </div>

                        <div class="form-group col-md-3">	
                            <label>Data</label>
                            <input class="form-control" type="date" value="<?php echo $atendimentos['atendimento']->getData(); ?>"/>
                        </div>			
                    </div>
                </fieldset>

                <fieldset disabled>
                    <legend class="mb-4">Sintomas e Sinais</legend>

                    <input type="hidden" name="numeroSintomas" id="numeroSintomas" value="<?php echo count($atendimentos['sintomas']); ?>"/>

                    <div id="renderSintoma">

                    </div>
                </fieldset>

                <fieldset disabled>
                    <legend class="mb-4">Procedimento</legend>

                    <div class="form-group">
                        <label>Procedimento realizado</label>
                        <textarea class="form-control"><?php echo $atendimentos['atendimento']->getProcedimento(); ?></textarea>
                    </div>

                </fieldset>

                <div class="form-group">
                    <a name="desabilitar" class="btn btn-primary btn-block btn-lg" href="Listar.php">Voltar</a>
                </div>

            </form>
        </div>  

        <?php include_once '../Compartilhado/ModalErroSucesso.php'; ?>

        <?php include_once '../Compartilhado/Footer.php'; ?>

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

        <script src="../../JavaScript/Geral/bootstrap.js"></script>
        <script src="../../JavaScript/Geral/bootstrapValidation.js"></script>    
    </body>
</html>



