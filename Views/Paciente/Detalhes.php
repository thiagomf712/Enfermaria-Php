<?php
define('__ROOT__', dirname(__FILE__, 3));
require_once(__ROOT__ . '/Models/Usuario.php');
require_once(__ROOT__ . '/Models/Enums/Regime.php');

require_once(__ROOT__ . '/Controllers/PacienteController.php');

if (session_id() == '') {
    session_start();
}

$id = isset($_GET['paciente']) ? $_GET['paciente'] : 0;
$enderecoId = isset($_GET['endereco']) ? $_GET['endereco'] : 0;
$fichaMedicaId = isset($_GET['fichaMedica']) ? $_GET['fichaMedica'] : 0;

$paciente = PacienteController::RetornarPaciente($id, $enderecoId, $fichaMedicaId);

$reg = $paciente->getEndereco()->getRegime();

function DefinirChecked($regime, $valorSelecionado) {
    echo ($regime == $valorSelecionado) ? 'checked' : '';
}

if(!isset($_SESSION['usuario'])) {
    header("Location: ../Usuario/Login.php");
}

$usuario = unserialize($_SESSION['usuario']);
?>

<!DOCTYPE html>
<html>
    <head lang="pt-br">
        <title>Detalhes - Paciente</title>
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
                    <legend class="mb-4">Informações gerais do paciente</legend>
                    
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Nome</label>
                            <input type="text" class="form-control" value="<?php echo $paciente->getNome(); ?>"/>
                        </div>

                        <div class="form-group col-md-3">
                            <label>Ra</label>
                            <input type="number" class="form-control" value="<?php echo $paciente->getRa(); ?>"/>
                        </div>

                        <div class="form-group col-md-3">
                            <label >Data de nascimento</label>
                            <input type="date" class="form-control" value="<?php echo $paciente->getDataNascimento(); ?>"/>
                        </div>  
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md">
                            <label>Email</label>
                            <input type="email" class="form-control" value="<?php echo $paciente->getEmail(); ?>"/>
                        </div>

                        <div class="form-group col-md">
                            <label>Telefone</label>
                            <input type="tel" class="form-control" value="<?php echo $paciente->getTelefone(); ?>"/>
                        </div>
                    </div>
                </fieldset>
                <fieldset class="mt-4" disabled>
                    <legend class="mb-4">Ficha Médica</legend>
                    
                    <div class="form-group">
                        <label>Plano de saúde</label>
                        <input type="text" class="form-control" value="<?php echo $paciente->getFichaMedica()->getPlanoSaude(); ?>"/>
                    </div>

                    <div class="form-group">
                        <label>Problemas de saúde</label>
                        <textarea class="form-control"><?php echo $paciente->getFichaMedica()->getProblemaSaude(); ?></textarea>
                    </div>

                    <div class="form-group">
                        <label>Medicamentos de uso continuo</label>
                        <textarea class="form-control"><?php echo $paciente->getFichaMedica()->getMedicamento(); ?></textarea>
                    </div>

                    <div class="form-group">
                        <label>Alergias</label>
                        <textarea class="form-control"><?php echo $paciente->getFichaMedica()->getAlergia(); ?></textarea>
                    </div>

                    <div class="form-group">
                        <label>Cirurgias realizadas</label>
                        <textarea class="form-control"><?php echo $paciente->getFichaMedica()->getCirurgia(); ?></textarea>
                    </div>       
                </fieldset>

                <fieldset class="mt-4" disabled>
                    <legend class="mb-4">Endereço</legend>
                    
                    <fieldset class="form-group">
                        <div class="form-row">
                            <legend class="col-form-label col-md-2 pt-0">Regime</legend>
                            <div class="col-sm-10">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="regime" id="interno" value="1" onchange="altEndereco(this)" <?php DefinirChecked($reg, Regime::Interno)?>>
                                    <label class="form-check-label" for="interno">Interno</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="regime" id="externo" value="2" onchange="altEndereco(this)" <?php DefinirChecked($reg, Regime::Externo)?>>
                                    <label class="form-check-label" for="externo">Externo</label>
                                </div>   
                            </div>
                        </div>
                    </fieldset>

                    <div class="form-row">
                        <div class="form-group col-md">
                            <label>Rua</label>
                            <input type="text" class="form-control" value="<?php echo $paciente->getEndereco()->getLogradouro(); ?>"/>
                        </div>

                        <div class="form-group col-md-3">
                            <label>Numero</label>
                            <input type="number" class="form-control" value="<?php echo $paciente->getEndereco()->getNumero(); ?>"/>
                        </div>
                    </div>             

                    <div class="form-row">
                        <div class="form-group col-md">
                            <label>Complemento</label>
                            <input type="text" class="form-control" value="<?php echo $paciente->getEndereco()->getComplemento(); ?>"/>
                        </div>  

                        <div class="form-group col-md-4">
                            <label>CEP</label>
                            <input type="text" class="form-control" value="<?php echo $paciente->getEndereco()->getCep(); ?>"/>
                        </div>  
                    </div>  

                    <div class="form-row">
                        <div class="form-group col-md">
                            <label>Bairro</label>
                            <input type="text" class="form-control" value="<?php echo $paciente->getEndereco()->getBairro(); ?>"/>
                        </div>

                        <div class="form-group col-md">
                            <label>Cidade</label>
                            <input type="text" class="form-control" value="<?php echo $paciente->getEndereco()->getCidade(); ?>"/>
                        </div>

                        <div class="form-group col-md">
                            <label>Estado</label>
                            <input type="text" class="form-control" value="<?php echo $paciente->getEndereco()->getEstado(); ?>"/>
                        </div>
                    </div>
                </fieldset>

                <div class="form-group">
                    <button type="button" class="btn btn-primary btn-block btn-lg" onclick="history.go(-1);">Voltar</button>
                </div>

            </form>
        </div>       

        <?php include_once '../Compartilhado/Footer.php'; ?>

        <script src="../../JavaScript/Geral/bootstrap.js"></script>
        <script src="../../JavaScript/Geral/bootstrapValidation.js"></script>  
    </body>
</html>

