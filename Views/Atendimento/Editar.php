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
        <title>Editar - Atendimento</title>
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
            <form method="POST" action="../../Controllers/AtendimentoController.php" class="needs-validation" novalidate onsubmit="return ValidarForm()">
                <input type="hidden" name="metodoAtendimento" value="Editar"/>

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
                <fieldset class="mt-4">
                    <legend class="mb-4">Informações do atendimento</legend>

                    <input type="hidden" name="atendimentoId" id="atendimentoId" value="<?php echo $atendimentos['atendimento']->getId(); ?>"/>

                    <div class="form-row">
                        <div class="form-group col-md-7">
                            <label for="atendente">Atendente</label>
                            <select class="form-control" id="atendente" name="atendente">
                                <?php for ($i = 0; $i < count($funcionarios); $i++) : ?>
                                    <option value="<?php echo $funcionarios[$i]['Id'] ?>" <?php echo ($atendimentos['atendimento']->getFuncionario() == $funcionarios[$i]['Id']) ? 'selected' : '' ?>><?php echo $funcionarios[$i]['Nome'] ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>

                        <div class="form-group col-md-2">	
                            <label for="hora">Hora</label>
                            <input type="time" name="hora" id="hora" class="form-control" required value="<?php echo $atendimentos['atendimento']->getHora(); ?>"/>
                            <div class="invalid-feedback" id="erroHora"></div>
                        </div>

                        <div class="form-group col-md-3">	
                            <label for="data">Data</label>
                            <input class="form-control" type="date" name="data" id="data" required value="<?php echo $atendimentos['atendimento']->getData(); ?>"/>
                            <div class="invalid-feedback" id="erroData"></div>
                        </div>			
                    </div>
                </fieldset>

                <fieldset>
                    <legend class="mb-4">Sintomas e Sinais</legend>

                    <input type="hidden" name="numeroSintomas" id="numeroSintomas" value="<?php echo count($atendimentos['sintomas']); ?>"/>
                    <input type="hidden" name="numeroSintomasbd" id="numeroSintomasbd" value="<?php echo count($atendimentos['sintomas']); ?>"/>
                    <input type="hidden" name="sintomaDeletado" id="sintomaDeletado" value=""/>
                    
                    <div id="renderSintoma">

                    </div>

                    <div class="form-group float-right">
                        <button class="btn btn-primary mr-2" type="button" id="adicionar">Adicionar Sintoma</button>
                        <button class="btn btn-primary " type="button" id="remover">Remover Sintoma</button>
                    </div>

                </fieldset>

                <fieldset>
                    <legend class="mb-4">Procedimento</legend>

                    <div class="form-group">
                        <label for="procedimento" >Procedimento realizado</label>
                        <textarea class="form-control" id="procedimento" name="procedimento" rows="3" maxlength="100"><?php echo $atendimentos['atendimento']->getProcedimento(); ?></textarea>
                    </div>

                </fieldset>

                <div class="form-row">
                    <div class="form-group mt-4 col-md">
                        <input name="desabilitar" class="btn btn-primary btn-block btn-lg" type="submit" value="Salvar Alterações" />
                    </div>
                    <div class="form-group mt-4 col-md">
                        <a name="desabilitar" class="btn btn-primary btn-block btn-lg" href="Listar.php">Cancelar</a>
                    </div>
                </div>
            </form>
        </div>  

        <?php include_once '../Compartilhado/ModalErroSucesso.php'; ?>

        <?php include_once '../Compartilhado/Footer.php'; ?>

        <script src="../../JavaScript/jquery-3.4.1.js"></script>
        <script>
                var adicionar = document.getElementById('adicionar');
                var remover = document.getElementById('remover');
                var renderSintoma = document.getElementById('renderSintoma');
                var desabilitar = document.getElementsByName('desabilitar');

                adicionar.addEventListener("click", Adicionar);
                remover.addEventListener("click", Remover);

                desabilitar[0].addEventListener("click", DesabilitarSintomas);
                desabilitar[1].addEventListener("click", DesabilitarSintomas);

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

                function Adicionar() {
                    $.post('Auxiliar.php', {function: 'AdicionarSintoma'}, function (data) {
                        var divNova = document.createElement("div");

                        divNova.innerHTML = JSON.parse(data);
                        renderSintoma.appendChild(divNova);
                    });

                    contadorSintomas++;
                    inputContador.value = contadorSintomas;
                }

                function Remover() {
                    $.post('Auxiliar.php', {function: 'RemoverSintoma'}, function () {
                        if (contadorSintomas > 1) {
                            var id = 'div' + inputContador.value;

                            var node = document.getElementById(id);
                            
                            var sintomaDeletado = node.firstElementChild.value;
                            
                            var valorOriginal = document.getElementById('sintomaDeletado').value;

                            var valorAlterado = valorOriginal + "/" + sintomaDeletado;
                            
                            document.getElementById('sintomaDeletado').value = valorAlterado;

                            renderSintoma.removeChild(node.parentNode);
                            contadorSintomas--;
                            inputContador.value = contadorSintomas;
                        }
                    });
                }
        </script>

        <script src="../../JavaScript/Geral/bootstrap.js"></script>
        <script src="../../JavaScript/Geral/bootstrapValidation.js"></script>   
        <script src="../../JavaScript/Paciente/cadastroPaciente.js"></script>  
    </body>
</html>

