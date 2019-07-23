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

                    <input type="hidden" name="id" value="<?php echo $paciente->getId(); ?>"/>
                    
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="nome" >Nome</label>
                            <input type="text" class="form-control" id="nome" name="nome" required maxlength="50" minlength="3" value="<?php echo $paciente->getNome(); ?>"/>
                            <div class="invalid-feedback" id="erroNome"></div>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="ra" >Ra</label>
                            <input type="number" class="form-control" id="ra" name="ra" required min="1" value="<?php echo $paciente->getRa(); ?>"/>
                            <div class="invalid-feedback" id="erroRa"></div>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="dataNascimento" >Data de nascimento</label>
                            <input type="date" class="form-control" id="dataNascimento" name="dataNascimento" required value="<?php echo $paciente->getDataNascimento(); ?>"/>
                            <div class="invalid-feedback" id="erroDataNascimento"></div>
                        </div>  
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md">
                            <label for="email" >Email</label>
                            <input type="email" class="form-control" id="email" name="email" maxlength="50" value="<?php echo $paciente->getEmail(); ?>"/>
                            <div class="invalid-feedback" id="erroEmail"></div>
                        </div>

                        <div class="form-group col-md">
                            <label for="telefone" >Telefone</label>
                            <input type="tel" class="form-control" id="telefone" name="telefone" pattern="[0-9]{2} [0-9]{5}-[0-9]{4}" aria-describedby="telefoneHelp" value="<?php echo $paciente->getTelefone(); ?>"/>
                            <small id="telefoneHelp" class="form-text text-muted">Exemplo: 12 12345-1234</small>
                            <div class="invalid-feedback" id="erroTelefone"></div> 
                        </div>
                    </div>
                </fieldset>
                <fieldset class="mt-4" disabled>
                    <legend class="mb-4">Ficha Médica</legend>
                    
                    <input type="hidden" name="fichaMedicaId" value="<?php echo $paciente->getFichaMedica()->getId(); ?>"/>
                    
                    <div class="form-group">
                        <label for="planoSaude" >Plano de saúde</label>s
                        <input type="text" class="form-control" id="planoSaude" name="planoSaude" maxlength="100" placeholder="Deixa em branco se não possuir" value="<?php echo $paciente->getFichaMedica()->getPlanoSaude(); ?>"/>
                    </div>

                    <div class="form-group">
                        <label for="problemaSaude" >Problemas de saúde</label>
                        <textarea class="form-control" id="problemaSaude" name="problemaSaude" rows="3" maxlength="100" placeholder="Deixa em branco se não possuir"><?php echo $paciente->getFichaMedica()->getProblemaSaude(); ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="medicamento" >Medicamentos de uso continuo</label>
                        <textarea class="form-control" id="medicamento" name="medicamento" rows="3" maxlength="100" placeholder="Deixa em branco se não fazer uso"><?php echo $paciente->getFichaMedica()->getMedicamento(); ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="alergia" >Alergias</label>
                        <textarea class="form-control" id="alergia" name="alergia" rows="3" maxlength="100" placeholder="Deixa em branco se não possuir"><?php echo $paciente->getFichaMedica()->getAlergia(); ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="cirurgia" >Cirurgias realizadas</label>
                        <textarea class="form-control" id="cirurgia" name="cirurgia" rows="3" maxlength="100" placeholder="Deixa em branco se não realizou nenhuma"><?php echo $paciente->getFichaMedica()->getCirurgia(); ?></textarea>
                    </div>       
                </fieldset>

                <fieldset class="mt-4" disabled>
                    <legend class="mb-4">Endereço</legend>
                    
                    <input type="hidden" name="enderecoId" value="<?php echo $paciente->getEndereco()->getId(); ?>"/>
                    
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
                            <label for="rua" >Rua</label>
                            <input type="text" class="form-control" id="rua" name="rua" maxlength="50" value="<?php echo $paciente->getEndereco()->getLogradouro(); ?>"/>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="numero" >Numero</label>
                            <input type="number" class="form-control" id="numero" name="numero" min="1" max="9999" value="<?php echo $paciente->getEndereco()->getNumero(); ?>"/>
                            <div class="invalid-feedback" id="erroNumero"></div>
                        </div>
                    </div>             

                    <div class="form-row">
                        <div class="form-group col-md">
                            <label for="complemento" >Complemento</label>
                            <input type="text" class="form-control" id="complemento" name="complemento" maxlength="20" value="<?php echo $paciente->getEndereco()->getComplemento(); ?>"/>
                        </div>  

                        <div class="form-group col-md-4">
                            <label for="cep" >CEP</label>
                            <input type="text" class="form-control" id="cep" name="cep" maxlength="9" pattern="[0-9]{5}-[0-9]{3}" aria-describedby="cepHelp" value="<?php echo $paciente->getEndereco()->getCep(); ?>"/>
                            <small id="cepHelp" class="form-text text-muted">Exemplo: 12345-123</small>
                            <div class="invalid-feedback" id="erroCep"></div>
                        </div>  
                    </div>  

                    <div class="form-row">
                        <div class="form-group col-md">
                            <label for="bairro" >Bairro</label>
                            <input type="text" class="form-control" id="bairro" name="bairro" maxlength="50" value="<?php echo $paciente->getEndereco()->getBairro(); ?>"/>
                        </div>

                        <div class="form-group col-md">
                            <label for="cidade" >Cidade</label>
                            <input type="text" class="form-control" id="cidade" name="cidade" maxlength="50" value="<?php echo $paciente->getEndereco()->getCidade(); ?>"/>
                        </div>

                        <div class="form-group col-md">
                            <label for="estado" >Estado</label>
                            <input type="text" class="form-control" id="estado" name="estado" maxlength="50" value="<?php echo $paciente->getEndereco()->getEstado(); ?>"/>
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