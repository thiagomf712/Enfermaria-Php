<?php
define('__ROOT__', dirname(__FILE__, 3));
require_once(__ROOT__ . '/Models/Usuario.php');
require_once(__ROOT__ . '/Models/Enums/Regime.php');

require_once(__ROOT__ . '/Controllers/PacienteController.php');

if (session_id() == '') {
    session_start();
}

if (!isset($_SESSION['usuario'])) {
    header("Location: ../Usuario/Login.php");
}

$usuario = unserialize($_SESSION['usuario']);

$pacienteId = PacienteController::RetornarIdPaciente($usuario->getId(), true);

$id = $pacienteId[0];
$enderecoId = $pacienteId[1];
$fichaMedicaId = $pacienteId[2];

$paciente = PacienteController::RetornarPaciente($id, $enderecoId, $fichaMedicaId);

$reg = $paciente->getEndereco()->getRegime();

function DefinirChecked($regime, $valorSelecionado) {
    echo ($regime == $valorSelecionado) ? 'checked' : '';
}
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

        <title>Detalhes - paciente</title>
    </head>
    <body>
        <!-- Barra de navegação -->
        <?php include_once '../Compartilhado/Navbar.php'; ?>    

        <!-- Area da lista -->
        <div id="area-principal" class="container bg-primary">
            <div class="col-md-10 offset-md-1">
                <form>

                    <!-- Informações gerais -->
                    <fieldset disabled>
                        <legend class="mb-4">Informações gerais do paciente</legend>

                        <div class="form-row">

                            <!-- Nome -->
                            <div class="form-group col-md-5 col-lg-6">
                                <label>Nome</label>
                                <input type="text" class="form-control" value="<?php echo $paciente->getNome(); ?>"/>
                            </div>

                            <!-- Ra -->
                            <div class="form-group col-md-3">
                                <label>Ra</label>
                                <input type="number" class="form-control" value="<?php echo $paciente->getRa(); ?>"/>
                            </div>

                            <!-- Data Nascimento -->
                            <div class="form-group col-md-4 col-lg-3">
                                <label >Data de nascimento</label>
                                <input type="date" class="form-control" value="<?php echo $paciente->getDataNascimento(); ?>"/>
                            </div>  
                        </div>

                        <div class="form-row">

                            <!-- Email -->
                            <div class="form-group col-md">
                                <label>Email</label>
                                <input type="email" class="form-control" value="<?php echo $paciente->getEmail(); ?>"/>
                            </div>

                            <!-- Telefone -->
                            <div class="form-group col-md">
                                <label>Telefone</label>
                                <input type="tel" class="form-control" value="<?php echo $paciente->getTelefone(); ?>"/>
                            </div>
                        </div>
                    </fieldset>

                    <!-- Ficha Média -->
                    <fieldset class="mt-4" disabled>
                        <legend class="mb-4">Ficha Médica</legend>

                        <!-- Plano -->
                        <div class="form-group">
                            <label>Plano de saúde</label>
                            <input type="text" class="form-control" value="<?php echo $paciente->getFichaMedica()->getPlanoSaude(); ?>"/>
                        </div>

                        <!-- Problemas -->
                        <div class="form-group">
                            <label>Problemas de saúde</label>
                            <textarea class="form-control"><?php echo $paciente->getFichaMedica()->getProblemaSaude(); ?></textarea>
                        </div>

                        <!-- Medicamentos -->
                        <div class="form-group">
                            <label>Medicamentos de uso continuo</label>
                            <textarea class="form-control"><?php echo $paciente->getFichaMedica()->getMedicamento(); ?></textarea>
                        </div>

                        <!-- Alergias -->
                        <div class="form-group">
                            <label>Alergias</label>
                            <textarea class="form-control"><?php echo $paciente->getFichaMedica()->getAlergia(); ?></textarea>
                        </div>

                        <!-- Cirurgias -->
                        <div class="form-group">
                            <label>Cirurgias realizadas</label>
                            <textarea class="form-control"><?php echo $paciente->getFichaMedica()->getCirurgia(); ?></textarea>
                        </div>       
                    </fieldset>

                    <!-- Endereço -->
                    <fieldset class="mt-4" disabled>
                        <legend class="mb-4">Endereço</legend>

                        <!-- Regime -->
                        <fieldset class="form-group">
                            <div class="form-row">
                                <legend class="col-form-label col-md-2 pt-0">Regime</legend>

                                <div class="col-sm-10">

                                    <!-- Interno -->
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="regime" id="interno" value="1" onchange="altEndereco(this)" <?php DefinirChecked($reg, Regime::Interno) ?>>
                                        <label class="form-check-label" for="interno">Interno</label>
                                    </div>

                                    <!-- Externo -->
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="regime" id="externo" value="2" onchange="altEndereco(this)" <?php DefinirChecked($reg, Regime::Externo) ?>>
                                        <label class="form-check-label" for="externo">Externo</label>
                                    </div>   
                                </div>
                            </div>
                        </fieldset>

                        <div class="form-row">

                            <!-- Rua -->
                            <div class="form-group col-md">
                                <label>Rua</label>
                                <input type="text" class="form-control" value="<?php echo $paciente->getEndereco()->getLogradouro(); ?>"/>
                            </div>

                            <!-- Numero -->
                            <div class="form-group col-md-3">
                                <label>Numero</label>
                                <input type="number" class="form-control" value="<?php echo $paciente->getEndereco()->getNumero(); ?>"/>
                            </div>
                        </div>             

                        <div class="form-row">
                            <!-- Complemento -->
                            <div class="form-group col-md">
                                <label>Complemento</label>
                                <input type="text" class="form-control" value="<?php echo $paciente->getEndereco()->getComplemento(); ?>"/>
                            </div>  

                            <!-- CEP -->
                            <div class="form-group col-md-4">
                                <label>CEP</label>
                                <input type="text" class="form-control" value="<?php echo $paciente->getEndereco()->getCep(); ?>"/>
                            </div>  
                        </div>  

                        <div class="form-row">

                            <!-- Bairro -->
                            <div class="form-group col-md">
                                <label>Bairro</label>
                                <input type="text" class="form-control" value="<?php echo $paciente->getEndereco()->getBairro(); ?>"/>
                            </div>

                            <!-- Cidade -->
                            <div class="form-group col-md">
                                <label>Cidade</label>
                                <input type="text" class="form-control" value="<?php echo $paciente->getEndereco()->getCidade(); ?>"/>
                            </div>

                            <!-- Estado -->
                            <div class="form-group col-md">
                                <label>Estado</label>
                                <input type="text" class="form-control" value="<?php echo $paciente->getEndereco()->getEstado(); ?>"/>
                            </div>
                        </div>
                    </fieldset>

                    <!-- Botão -->
                    <div class="form-group">
                        <button type="button" class="btn btn-secondary btn-block mt-4" onclick="history.go(-1);">Voltar</button>
                    </div>

                </form>
            </div>
        </div>       

        <!-- Rodapé -->    
        <?php include_once '../Compartilhado/Footer.php'; ?>

        <script src="../../bootstrap/js/bootstrap.min.js"></script>
        <script src="../../JavaScript/Geral/bootstrapValidation.js"></script>    
    </body>
</html>

